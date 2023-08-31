<?php

namespace App\Http\Controllers;

use App\Helpers\HelperClass;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Paystack;
use App\Models\ChargesPayment;

use App\Models\VendingTransaction;
use App\Models\User;
use App\Models\Estate;
use App\Models\estateuser;
use App\Models\PaymentTransact;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\Managers;
use App\Models\Notification;
use App\Models\ServiceAccount;
class PaymentGatewayController extends Controller
{


    public function redirectToGateway(Request $request)
    {

        $customer_email = $request->email;
        $amount = $request->amount; //converting to kobo - paystack rule
        $package = "basic";
        $reference = Paystack::genTranxRef();
        $kobo = ($amount) * 100; //add the user inputted amount and the outstanding fees
        $metadata = ['customer_id' => 1, 'client_id' => 12, 'package' => $package]; //metadata for the data i need
        $request->request->add(['reference' => $reference, 'email' => $customer_email, 'amount' => $kobo, 'currency' => 'NGN', 'channels' => ['card', 'bank_transfer'], 'metadata' => $metadata, 'callback_url' => env('APP_URL') . 'payment/callback']);
        try { //to ensure the page return back to the user when the session has expired
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            \Log::info($e);
            return \response()->json(["id" => "error", "msg" => "Error occur while access payment gateway, please try again!!!"]);

        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        \Log::info($paymentDetails);
        if($paymentDetails['status'] ==true){
            \Log::info($paymentDetails['data']);
            
            \Log::info($paymentDetails['data']['metadata']);
            \Log::info($paymentDetails['data']['metadata']['customer_id']);
            
            dd($paymentDetails['data']['metadata']['customer_id']);
            
        }
        
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
    
     public function checkMeter($request)
    {
        set_time_limit(0);
        $meterPAN = $request['meternumber'];
        $amount = $request['amount'];
        $vendamt = $amount;
        $eUser = estateuser::where('meternumber', $meterPAN)->first();
        $manager_user_id = $eUser->manager_user_id;
        $setting = Setting::where('manager_user_id', $manager_user_id)->first();
        $amount = $amount;
        $serviceact = ServiceAccount::where('manager_user_id', $manager_user_id)->where('service_type', 0)->first();
        $accountname = $serviceact->account_name;
        $accountnum = $serviceact->account_number;
        $bankname = $serviceact->bank;
        $customer_ref =  Paystack::genTranxRef();
        $request["user"]=$eUser;
        $request["customer_ref"]=$customer_ref;
        $request["manager_id"]=$manager_user_id;
        $request["accountname"]=$accountname;
        $request["accountnum"]=$accountnum;
        $request["bankname"]=$bankname;
        if ($eUser->verified == 1) {
            $transact = new PaymentTransact();
            $transact->payerid = $eUser->user_id;
            $transact->path = 4;
            $transact->channel = 2;
            $transact->customer_ref = $customer_ref;
            $transact->amount = (int) $amount;
            $transact->charged_amt = $setting->processing_fee+150;
            $transact->customer = json_encode($request);
            $transact->vend_value = $vendamt-($setting->processing_fee+150);
            $transact->merchant = $manager_user_id;
            $transact->payment_status = "Processing";
            $transact->save();
            return response()->json([
                "status" => "ok",
                "amount" => $amount,
                "customer_ref" => $customer_ref,
                "manager_id" => $manager_user_id,
                "accountname" => $accountname,
                "accountnum" => $accountnum,
                "bankname" => $bankname,
                "msg" => "proceed",
            ]);
        }

        try {
            $params = [];
            $url = config('hinge.hingeurl') . "check_meter";
            $params['access_key'] = config('hinge.hingekey');
            $params['meternumber'] = $meterPAN;
            $resp = Http::withOptions(["verify" => true])
                ->post($url, $params);
            \Log::info($resp);
            $resp = json_decode($resp);
            if ($resp->status == "ok") {
                $response = json_decode($resp->msg);
                if ($response->statusCode == "0") {
                    $eUser->verified = 1;
                    $eUser->update();
                    $transact = new PaymentTransact();
                    $transact->payerid = $eUser->user_id;
                    $transact->path = 4;
                    $transact->channel = 2;
                    $transact->customer_ref = $customer_ref;
                    $transact->amount = (int) $amount;
                    $transact->charged_amt = $setting->processing_fee+150;
                    $transact->customer = json_encode($request);
                    $transact->vend_value = $vendamt-($setting->processing_fee+150);
                    $transact->merchant = $manager_user_id;
                    $transact->payment_status = "Processing";
                    $transact->save();
                    return response()->json([
                        "status" => "ok",
                        "amount" => $amount,
                        "customer_ref" => $customer_ref,
                        "manager_id" => $manager_user_id,
                        "accountname" => $accountname,
                        "accountnum" => $accountnum,
                        "bankname" => $bankname,
                        "msg" => "proceed",
                    ]);
                } else {
                    return response()->json([
                        "status" => "info",
                        "msg" => "Error occur verifing customer",
                    ]);
                }
            }
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                "status" => "info",
                "msg" => "Error occur verifing customer",
            ]);
        }
    }
    public function verifyCustomer(Request $request)
    {
        $input = $request->all();
        $meterPAN = $request->meternumber;
        $eUser = estateuser::where('meternumber', $meterPAN)->first();
        if ($eUser) {
            if ($input['product'] == "power") {
                $amount = (int) $request->amount;
                if ($eUser->status == 0) {
                    \Session::put('error', "Account is locked,Contact the manager, Thanks");
                    return response()->json([
                        "status" => "info",
                        "msg" => "Account is locked,Contact the manager, Thanks",
                    ]);
                }
                $manageruser_id = $eUser->manager_user_id;
                $minVend = Setting::where('manager_user_id', $manageruser_id)->value('min_vend');
                if ($amount < $minVend) {
                    \Session::put('error', "Minimim amount to buy is NGN" . $minVend . ", Thanks");
                    return response()->json([
                        "status" => "info",
                        "msg" => "Minimim amount to buy is NGN" . $minVend . ", Thanks",
                    ]);
                }
                $estate = Estate::where('id', $eUser->estate_id)->first();
                $estateChg = $estate->service_charge;
                $xMonth = $estate->exipre_tolerance;
                if ((int) $estateChg > 0.00) {
                    $cPayment = ChargesPayment::where('meternumber', $meterPAN)->orderBy('id', 'desc')->first();
                    if ($cPayment == null) {
                        \Session::put('error', "Service charge fee payment pending, please make payment, Thanks");
                        return response()->json([
                            "status" => "info",
                            "msg" => "Service charge fee payment pending, please make payment, Thanks",
                        ]);
                    }
                    
                    $payday = $cPayment->payment_date;
                    $expireDate = Carbon::parse($payday)->subDay()->format('Y-m-d');
                    $today = date("Y-m-d");
                    $exDate = date('Y-m-d', strtotime($expireDate));
                    $nowDate = date('Y-m-d', strtotime($today));
                    if ($nowDate > $exDate) {
                        \Session::put('error', "Service charge fee payment pending, please make payment, Thanks");
                        return response()->json([
                            "status" => "info",
                            "msg" => "Service charge fee payment pending, please make payment, Thanks",
                        ]);
                    }
        
                }
                return $this->checkmeter($input);
            } else {
    
                $amount = $request->scamount;
                $paid_month = $request->nummonth;
                $manager_user_id = $eUser->manager_user_id;
                $setting = Setting::where('manager_user_id', $manager_user_id)->first();
                $service_fee= $setting->service_trans_fee;
                $vend_fee= ($setting->transaction_fee)*$paid_month;
                $trans_fee = $service_fee+ $vend_fee;
                $vendamount = $amount - ($trans_fee + 50 + $setting->processing_fee);
                $eUser->paid_month = $paid_month;
                $customer_ref =  Paystack::genTranxRef();
                $serviceact = ServiceAccount::where('manager_user_id', $manager_user_id)->where('service_type', 1)->first();
                $accountname = $serviceact->account_name;
                $accountnum = $serviceact->account_number;
                $bankname = $serviceact->bank;
                
              
                $input["user"]=$eUser;
                $input["customer_ref"]=$customer_ref;
                $input["manager_id"]=$manager_user_id;
                $input["accountname"]=$accountname;
                $input["accountnum"]=$accountnum;
                $input["bankname"]=$bankname;
                
                $transact = new PaymentTransact();
                $transact->payerid = $eUser->user_id;
                $transact->channel = 2;
                $transact->path = 4;
                $transact->customer_ref = $customer_ref;
                $transact->amount = (int) $amount;
                $transact->charged_amt = $trans_fee + 50 + $setting->processing_fee;
                $transact->customer = json_encode($input);
                $transact->vend_value = $vendamount;
                $transact->merchant = $manager_user_id;
                $transact->category = 1;
                $transact->payment_status = "Processing";
                $transact->save();
                return response()->json([
                    "status" => "ok",
                    "amount" => $amount,
                    "customer_ref" => $customer_ref,
                    "manager_id" => $manager_user_id,
                    "accountname" => $accountname,
                    "accountnum" => $accountnum,
                    "bankname" => $bankname,
                    "msg" => "proceed",
                ]);
            }
        } else {
            \Session::put('error', "Meter not found, please contact the administrator, Thanks");
            return response()->json([
                "status" => "info",
                "msg" => "Meter not found, please contact the administrator, Thanks",
            ]);
        }
    }

    public function verifyPayment(Request $request)
    {
        \Log::info("User clicked ");
        \Log::info($request);
        set_time_limit(0);
        sleep(60);
        $paytrans = PaymentTransact::where('customer_ref',$request->customer_ref)->first();
        if($paytrans){
            if($paytrans->service_status==true || $paytrans->service_status == 1) {
                $vendTran = VendingTransaction::where('txref', $paytrans->txref)->first();
                return redirect()->back()->with("info", "Your vending was initally successfull, here is your token: " . $vendTran->token);
            }
        }
        $manager_id = $paytrans->merchant;
        $vendamt = $paytrans->vend_value;
        $user = User::where('id', $paytrans->payerid)->first();
        $service =  $paytrans->category;
        if($request->has('ref')){
            $payment_ref=$request->ref;
            try{
                if ((int)$service == 0) {
                    $serviceact = ServiceAccount::where('manager_user_id', $manager_id)->where('service_type', 0)->first();
                    $accountname = $serviceact->account_name;
                    $accountnum = $serviceact->account_number;
                    $bankname = $serviceact->bank;
                }else{
                    $serviceact = ServiceAccount::where('manager_user_id', $manager_id)->where('service_type', 1)->first();
                    $accountname = $serviceact->account_name;
                    $accountnum = $serviceact->account_number;
                    $bankname = $serviceact->bank;
                }
            }catch (\Throwable $th) {
                //throw $th
                \Log::info($th);
            }
            $url = config('hinge.hingeurl') . "verify/bani/payment";
            $parameter = [];
            $parameter['access_key'] = config('hinge.hingekey');
            $parameter['payment_ref'] = $payment_ref;
            $parameter['manager_id'] = $manager_id;
            $parameter['vendamt'] = $vendamt;
            $parameter['payer_name'] = $user->name;
            $parameter['customer'] = $paytrans->customer;
            $parameter['service'] = $service;
            $parameter['type'] = $request->type;
            $parameter['account_name'] = $accountname;
            $parameter['account_num'] = $accountnum;
            $parameter['bankname'] = $bankname;
            $resp = Http::withOptions(["verify" => true])
                ->post($url, $parameter);
            try {
                //code...
                if ($resp["status"] == "ok") {
                    $customer = json_decode($paytrans->customer);
                    $meter_number = $customer->meternumber;
                    $paytrans->payment_status = "successful";
                    $paytrans->txref =  $payment_ref;
                    $paytrans->update();
                    if ((int)$service == 0) {
                        return  app('App\Http\Controllers\PowerManagerController')->VendUnit($meter_number, $payment_ref, $manager_id);
                    } else {
                        $paid_month = $customer->paid_month;
                        $estate = $customer->estate_id;
                        $phone = $customer->phone;
                        $charged = ChargesPayment::where('txref', $payment_ref)->first();
                        if ($charged) {
                            return;
                        }
                        $from = Carbon::now()->endOfMonth();
                        $to = Carbon::today();
                        $diff_in_days = $to->diffInDays($from);
                        $lastpaydate = Carbon::today()->endOfMonth()->addMonths($paid_month)->format("Y-m-d");
                        if ($diff_in_days > 10) {
                            $lastpaydate = Carbon::today()->startOfMonth()->addMonths($paid_month)->format("Y-m-d");
                        }
                        $paydate = ChargesPayment::where('meternumber', $meter_number)->orderBy('id', 'desc')->value('payment_date');
                        if ($paydate) {
                            $lastpaydate = Carbon::parse($paydate)->addMonths($paid_month)->format("Y-m-d");
                        }
    
                        $charged = new ChargesPayment();
                        $charged->estate_id = $estate;
                        $charged->phonenumber = $phone;
                        $charged->meternumber = $meter_number;
                        $charged->txref = $payment_ref;
                        $charged->user_id = $paytrans->payerid;
                        $charged->amount = $vendamt;
                        $charged->email = $user->email;
                        $charged->payment_date = $lastpaydate;
                        $charged->no_of_month = $paid_month;
                        $charged->save();
                        $notify = new Notification();
                        $notify->user_id = $paytrans->payerid;
                        $notify->type = 1;
                        $notify->notify_msg = $paid_month . " month(s) service charge payment was successful.";
                        $notify->save();
    
                        $msg = "Payment successful";
    
                        $manageremail = Managers::where('user_id', $manager_id)->value('email');
                        $helper = new HelperClass();
                        $messageadmin = $user->name . " just pay " . $vendamt . " for his/her service charge for " . $paid_month . " month(s)";
                        $helper->sendEmail($manageremail, "Service charged payment notificaton", $messageadmin);
                        return response()->json(route('feedback', ['status' => 'ok', 'msg' => $msg]));
                    }
                } else if ($resp["status"] == "info") {
                    $paytrans->payment_status = "On_going";
                    $paytrans->txref =  $payment_ref;
                    $paytrans->update();
                    $msg = $resp["msg"];
                    return response()->json(route('feedback', ['status' => 'error', 'msg' => $msg]));
                } else {
                    $paytrans->txref =  $payment_ref;
                    $paytrans->update();
                    $msg = json_decode($resp["msg"]);
                    return response()->json(route('feedback', ['status' => 'error', 'msg' => "Payment fail, try again later!!!"]));
                }
            } catch (\Throwable $th) {
                //throw $th
                \Log::info($th);
                return response()->json(route('feedback', ['status' => 'error', 'msg' => "Transaction error, please contact your manager to confirm yout transaction!!!"]));
            }
        }
        else{
             return response()->json(route('feedback', ['status' => 'error', 'msg' => "Transaction error, please contact your manager to confirm yout transaction!!!"]));
        }
    }
    
    public function transferwebhook(Request $request)
    { 
        \Log::info("webhook");
        \Log::info($request);
        $trans_ref=  $request->trans_ref;
        $customer_data = $request->customer;
        $email = $customer_data["email"];
        $product= $customer_data["product"];
        $meternumber= $customer_data["meternumber"];
        $pay_status = $request->pay_status;
        $customer_ref = $customer_data["customer_ref"];
        $paytrans = PaymentTransact::where('customer_ref', $customer_ref)->first();
        if($paytrans->service_status==true || $paytrans->service_status == 1) {
            $vendTran = VendingTransaction::where('txref', $trans_ref)->first();
            return redirect()->back()->with("info", "Your vending was initally successfull, here is your token: " . $vendTran->token);
        }
        $manager_id = $paytrans->merchant;
        $vendamt = $paytrans->vend_value;
        try {
            //code...
            if ($pay_status == "paid" || $pay_status == "completed"){
                $customer = json_decode($paytrans->customer);
                $meter_number = $customer->meternumber;
                $paytrans->payment_status = "successful";
                $paytrans->txref =  $trans_ref;
                $paytrans->update();
                if ($product== "power") {
                    return  app('App\Http\Controllers\PowerManagerController')->VendUnit($meter_number, $trans_ref, $manager_id);
                } else {
                    $user = User::where('id', $paytrans->payerid)->first();
                    $amount= $customer_data["scamount"];
                    $paid_month = $customer->paid_month;
                    $estate = $customer->estate_id;
                    $phone = $customer->phone;
                    $charged = ChargesPayment::where('txref', $trans_ref)->first();
                    if ($charged) {
                        return;
                    }
                    $from = Carbon::now()->endOfMonth();
                    $to = Carbon::today();
                    $diff_in_days = $to->diffInDays($from);
                    $lastpaydate = Carbon::today()->endOfMonth()->addMonths($paid_month)->format("Y-m-d");
                    if ($diff_in_days > 10) {
                        $lastpaydate = Carbon::today()->startOfMonth()->addMonths($paid_month)->format("Y-m-d");
                    }
                    $paydate = ChargesPayment::where('meternumber', $meter_number)->orderBy('id', 'desc')->value('payment_date');
                    if ($paydate) {
                        $lastpaydate = Carbon::parse($paydate)->addMonths($paid_month)->format("Y-m-d");
                    }

                    $charged = new ChargesPayment();
                    $charged->estate_id = $estate;
                    $charged->phonenumber = $phone;
                    $charged->meternumber = $meter_number;
                    $charged->txref = $trans_ref;
                    $charged->user_id = $paytrans->payerid;
                    $charged->amount = $amount;
                    $charged->email = $user->email;
                    $charged->payment_date = $lastpaydate;
                    $charged->no_of_month = $paid_month;
                    $charged->save();
                    $notify = new Notification();
                    $notify->user_id = $paytrans->payerid;
                    $notify->type = 1;
                    $notify->notify_msg = $paid_month . " month(s) service charge payment was successful.";
                    $notify->save();
                    $msg = "Payment successful";
                    $manageremail = Managers::where('user_id', $manager_id)->value('email');
                    $helper = new HelperClass();
                    $messageadmin = $user->name . " just pay " . $vendamt . " for his/her service charge for " . $paid_month . " month(s)";
                    $helper->sendEmail($manageremail, "Service charged payment notificaton", $messageadmin);
                    return response()->json(route('feedback', ['status' => 'ok', 'msg' => $msg]));
                }
            } else {
                $paytrans->txref =  $trans_ref;
                $paytrans->update();
                $msg = "Transaction not complete, Payment status is". $pay_status;
                return response()->json(route('feedback', ['status' => 'error', 'msg' => $msg]));
            }
        } catch (\Throwable $th) {
            //throw $th
            \Log::info($th);
            return response()->json(route('feedback', ['status' => 'error', 'msg' => "Transaction error, please contact your manager to confirm yout transaction!!!"]));
        }
       
    }


}