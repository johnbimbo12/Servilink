<?php

namespace App\Http\Controllers;

use App\Helpers\HelperClass;
use App\Models\AdminVend;
use App\Models\ChargesPayment;
use App\Models\CreditPurchase;
use App\Models\DieselManager;
use App\Models\Estate;
use App\Models\estateuser;
use App\Models\Notification;
use App\Models\PaymentTransact;
use App\Models\PowerManager;
use App\Models\Revenue;
use App\Models\ServiceAccount;
use App\Models\Setting;
use App\Models\User;
use App\Models\VendingTransaction;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Paystack;
use Redirect;

class PowerManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();
        if ($user->role == 2) {
            return view('manager.power_manager');
        } else if ($user->role == 4) {
            return view('resident.power_manager', compact('user'));
        } else if ($user->role == 1) {
            $wallet = Setting::where('manager_user_id', $user->id)->value('wallet_balance');
            $credit = CreditPurchase::where('service_type', 0)->where('pay_status', 0)->sum('amt_to_pay');
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $this_month = [$start, $end];
            $meter = estateuser::count();
            $prevenue = Revenue::whereBetween('created_at', $this_month)->sum('amount');
            $monthsale = VendingTransaction::where('verified', 1)->whereBetween('created_at', $this_month)->sum('vend_value');

            return view('admin.power_manager', compact('user', 'wallet', 'credit', 'monthsale', 'prevenue', 'meter'));
        }
    }
    public function testSMS()
    {
        $helper = new HelperClass();
        return $helper->useJSON("Your purchased meter unit token: ", '07065384842');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function purchaseunit(Request $request)
    {
        $input = $request->all();
        $meterPAN = $input['meternumber'];
        $eUser = estateuser::where('meternumber', $meterPAN)->first();
        // if (Auth::check()) {
        //     if (Auth::user()->role == 2 && $request->path != 0) {
        //         $payid = $eUser->user_id;
        //         $txref = PaymentTransact::where('payerid', $payid)
        //             ->where('payment_status', 'successful')
        //             ->where('category', 0)
        //             ->where('service_status', 0)
        //             ->orderBy('id', 'desc')
        //             ->value("txref");
        //         return $this->VendVerify($txref);
        //     }
        // }
        $amount = (int) $input['amount'];
        if ($eUser) {
            $manageruser_id = $eUser->manager_user_id;
            $minVend = Setting::where('manager_user_id', $manageruser_id)->value('min_vend');
            if((int) $input['paytype'] != 2){
                if ($amount < $minVend) {
                    if ($request->path == 2) {
                        return redirect()->route('power.manage')->with("error", "Minimim amount to buy is NGN" . $minVend);
                    }
                    return redirect()->route('feedback', ["status" => "error", "msg" => "Minimim amount to buy is NGN" . $minVend]);
                }
            }

            $cPayment = ChargesPayment::where('meternumber', $meterPAN)->orderBy('id', 'desc')->first();
            if ($cPayment == null) {
                if ($request->path == 2 || $request->path == 3) {
                    return redirect()->route('power.manage')->with("error", "Service charge fee payment pending, please make payment, Thanks");
                }
                return redirect()->route('feedback', ["status" => "error", "msg" => "Service charge fee payment pending, please make payment, Thanks"]);
            }
            $creditpurchase = CreditPurchase::where('meternumber', $meterPAN)->where('pay_status', 0)->orderBy('id', 'desc')->first();
            if ($creditpurchase) {
                if ($request->path == 2 || $request->path == 3) {
                    return redirect()->route('power.manage')->with("error", "You have a pending vending payment.Please make payment, Thanks");
                }
                return redirect()->route('feedback', ["status" => "error", "msg" => "You have a pending vending payment.Please Log into your account to clear it, Thanks"]);

            }
            
            if ($request->path == 3) {
                $diesel_deposit = DieselManager::where('meternumber', $meterPAN)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->first();
                if ($diesel_deposit) {
                } else {
                     return redirect()->route('power.manage')->with("error", "Your have a pending diesel deposite, please make payment by purchase power to enjoy this service, Thanks");
                }      
            }
           
            $payday = $cPayment->payment_date;
            $expireDate = Carbon::parse($payday)->subDay()->format('Y-m-d');
            $today = date("Y-m-d");
            $exDate = date('Y-m-d', strtotime($expireDate));
            $nowDate = date('Y-m-d', strtotime($today));
            if ($nowDate > $exDate) {
                if ($request->path == 2|| $request->path == 3) {
                    return redirect()->route('power.manage')->with("error", "Service charge fee payment pending, please make payment, Thanks");
                }
                return redirect()->route('feedback', ["status" => "error", "msg" => "Service charge fee payment pending, please make payment, Thanks"]);
            }

        } else {
            if ($request->path == 2 || $request->path == 3) {
                return redirect()->route('power.manage')->with("error", "Meter not found , contact the administrator");
            }
            return redirect()->route('feedback', ["status" => "error", "msg" => "Meter not found , contact the administrator"]);
        }
        return $this->checkmeter($request, $input, $manageruser_id);
    }

    public function checkMeter(Request $request, $param, $manageruser_id)
    {
        set_time_limit(0);
        $meterPAN = $param['meternumber'];
        $eUser = estateuser::where('meternumber', $meterPAN)->first();

        if ($eUser) {
            if ($eUser->status == 0) {
                if ((int) $request['path'] == 2) {
                    return redirect()->route('power.manage')->with("error", "Account lock contact the manager, Thanks!!!");
                }
                return redirect()->route('feedback', ["status" => "error", "msg" => "Account lock contact the manager, Thanks"]);
            }
        }
        if ($eUser->verified == 1) {
            $param['name'] = $meterPAN;
            $param['merchant'] = $manageruser_id;
            if ((int) $param['paytype'] == 2) {
                return $this->VendonCredit($request,$manageruser_id);
            }
            return $this->initialize($request, $param);
        }
        try {
            //code...
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
                    $param['name'] = $meterPAN;
                    $param['merchant'] = $manageruser_id;
                    if ((int) $param['paytype'] == 2) {
                        return $this->VendonCredit($request,$manageruser_id);
                    }
                    return $this->initialize($request, $param);
                } else {
                    if ((int) $param['path'] == 2) {
                        return redirect()->route('power.manage')->with("error", "Meter verification fails. Contact your provider");
                    }
                    return redirect()->route('feedback', ['status' => 'error', 'msg' => "Meter verification fails. Contact your provider"]);
                }

            } else {

                if ((int) $param['path'] == 2) {
                    return redirect()->route('power.manage')->with("error", "Error occur");
                }
                return redirect()->route('feedback', ['status' => 'error', 'msg' => "Error occur"]);
            }

        } catch (\Throwable $th) {
            \Log::error($th);
            if ((int) $param['path'] == 2) {
                return redirect()->route('power.manage')->with("error", "Error occur");
            }
            return redirect()->route('feedback', ['status' => 'error', 'msg' => "Error occur"]);
        }

    }

    public function initialize(Request $request, $param)
    {
        $email = $param['email'];
        $phone = $param['phone'];
        $name = $param['name'];
        $meter = $param['meternumber'];
        $amount =$request->amount;
        $path = $param['path'];
        $merchant = $param['merchant'];
        $charge = 0;
        $vendamt = $amount;
        $reference = Paystack::genTranxRef();
        $helper = new HelperClass();
        $diesel_deposite = false;
        $diesel_amount = 0;
        $estateuser = estateuser::where('meternumber', $meter)->first();
        $helper = new HelperClass();
      
        try {
            $diesel_deposit = DieselManager::where('meternumber', $meter)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->first();
            if ($diesel_deposit) {
            } else {
                $diesel_amount = Estate::where('id', $estateuser->estate_id)->value('diesel_deposit');
                $diesel_deposite = true;
                $amount = floatval($amount) +floatval($diesel_amount);
            
            }
        } catch (\Throwable $th) {
        }
        $pTransfee = $helper->transactionfee($amount); //get payment fee
        $amount2pay = $amount * 100;
        $vendamt = $vendamt - (100 + $pTransfee);
        $path = 0;
        $charge = 100 + $pTransfee;
        $manager_id = $merchant;
        $estateaccount = ServiceAccount::where('manager_user_id', $manager_id)->where('service_type', 0)->value('subaccount_id');
        $merchantamt = (int) $vendamt * 100;
        $split = [
            "type" => "flat",
            "currency" => "NGN",
            "bearer_type" => "account",
            "subaccounts" => [
                ["subaccount" => $estateaccount, "share" => $merchantamt],
                ["subaccount" => config('hinge.share_account'), "share" => 10000], //hinge share
            ],

        ];
        $metadata = [
            "meternumber" => $meter,
            "txref" => $reference,
            'email' => $email,
            'phone' => $phone,
            'diesel_deposite' => $diesel_deposite,
            'diesel_amount' => $diesel_amount,
        ];

        $data = [
            'reference' => $reference,
            'email' => $email,
            'phone' => $phone,
            'amount' => $amount2pay,
            'currency' => 'NGN',
            'channels' => ['card', 'bank_transfer'],
            'metadata' => $metadata,
            "split" => json_encode($split),
            'callback_url' => route('callback'),
        ];

        $request->request->add($data);

        try { //to ensure the page return back to the user when the session has expired

            $payerid = estateuser::where('meternumber', $meter)->value('user_id');
            $transact = new PaymentTransact();
            $transact->payerid = $payerid;
            $transact->path = (int) $request['path'];
            $transact->amount = (int) $amount;
            $transact->charged_amt = $charge;
            $transact->customer = json_encode($metadata);
            $transact->txref = $reference;
            $transact->vend_value = $vendamt;
            $transact->merchant = $merchant;
            $transact->payment_status = "Processing";
            $transact->save();
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            \Log::info("Initilized Error: ".$e->getMessage());
            if ((int) $param['path'] == 2) {
                return redirect()->route('power.manage')->with("error", "Payment service not available, try again later!!!");
            }
            return redirect()->route('feedback', ['status' => 'error', 'msg' => "Payment service not available, try again later!!!"]);
        }
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {
        $response = Paystack::getPaymentData();
        //\Log::info($response);
        $response_status = $response['status'];
        $response_msg = $response['message'];
        $response_data = $response['data'];
        $txID = $response_data['reference'];
        $transact = PaymentTransact::where("txref", $txID)->first();
        $path = $transact->path;
        if ($response_status == true) {
            $transact->payment_status = "successful";
            $transact->update();
            $merchant = $transact->merchant;
            $meter = estateuser::where('user_id', $transact->payerid)->value('meternumber');
            return $this->VendUnit($meter, $txID, $merchant);

        } else {

            $error = $response_msg;
            $message = "null";
            if ($path == 2) {
                return redirect()->route('power.manage')->with("error", $response_msg);
            }
            return redirect()->route('feedback', ['status' => 'error', 'msg' => $response_msg]);
        }

    }

    public function VendUnit($meterPAN, $txID, $merchantId)
    {
        $getCharged = false;
        $getTrans = PaymentTransact::where('txref', $txID)->first();
        if($getTrans){
            if($getTrans->service_status==true || $getTrans->service_status == 1) {
                $vendTran = VendingTransaction::where('txref', $getTrans->txref)->first();
                return redirect()->back()->with("info", "Your vending was initally successfull, here is your token: " . $vendTran->token);
            }
        }
        $path = $getTrans->path;
        $amtCharged = $getTrans->charged_amt;
        $amount = $getTrans->amount;
        $vend_amt = $getTrans->vend_value;
        $amttovend=$vend_amt;
        $estateuser = estateuser::where('meternumber', $meterPAN)->first();
        if ($estateuser->newPMeter == 1) {
            $amttovend = $amttovend - 10000;
        }
        
        try {
            $parameter = [];
            $url = config('hinge.hingeurl') . "vend_token";
            $parameter['access_key'] = config('hinge.hingekey');
            $parameter['meterpan'] = $meterPAN;
            $parameter['amount'] = $amttovend;
            $parameter['txref'] = $txID;
            $parameter['role'] = 3;
            $resp = Http::withOptions(["verify" => true])
                ->post($url, $parameter);
            if ($resp["status"] == "ok") {
                $response = json_decode($resp["msg"]);
                if ($response->statusCode == "0") {
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meterPAN;
                    $vendTran->merchant_id = $merchantId;
                    $vendTran->amount = $amount;
                    $vendTran->vend_value = $vend_amt;
                    $vendTran->txref = $txID;
                    $vendTran->response = json_encode($response->vendingData);
                    $vendTran->token = $response->vendingData->tokenDec;
                    $vendTran->tokenHex = $response->vendingData->tokenHex;
                    $vendTran->tariff = $response->vendingData->tariff;
                    $vendTran->unitsActual = $response->vendingData->unitsActual;
                    $vendTran->verified = true;
                    $vendTran->save();
                    $vendTran->charges = $amtCharged;

                    $estateuser->newPMeter = 0;
                    $estateuser->update();
                    $email = $estateuser->user->email;
                    $getTrans->service_status = true;
                    $getTrans->update();
                    $notify = new Notification();
                    $notify->user_id = $estateuser->user_id;
                    $notify->type = 0;
                    $notify->notify_msg = $response->vendingData->unitsActual . "kwH power unit  purchased successfully. Token: " . $response->vendingData->tokenDec;
                    $notify->save();
                    $message = "Transaction was successful, This is Your Token :" . $response->vendingData->tokenDec . " Transaction receipt will be sent to your email ";
                    if ($path == 2) {
                        return redirect()->route('power.manage')->with("success", "Purchase successfull, here is your token: " . $response->vendingData->tokenDec);
                    }
                    else if($path==4){
                        return response()->json(route('feedback', ['status' => 'ok', 'msg' => $message]));
                    }
                    $message = "Purchase successfull, here is your token: " . $response->vendingData->tokenDec;
                    $vendTran->email = $email;
                    HelperClass::SendTokenNotification($email, $vendTran);
                    $helper = new HelperClass();
                    // $helper->sendSMS($estateuser->phonenumber, $message);
                    $helper->sendEmailUser($email, "Token Purchase", $vendTran);
                 

                    return redirect()->route('feedback', ['status' => 'ok', 'msg' => $message]);

                } else {
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meterPAN;
                    $vendTran->merchant_id = $merchantId;
                    $vendTran->amount = $amount;
                    $vendTran->vend_value = $vend_amt;
                    $vendTran->txref = $txID;
                    $vendTran->response = json_encode($response);
                    $vendTran->verified = false;

                    $vendTran->save();

                    if ($path == 2) {
                        return redirect()->route('power.manage')->with("error", "Vending service not available,  Visit Transaction page to confirm service");
                    }else if($path==4){
                        $message = "Vending service not available,  Visit Transaction page to confirm service";// . $response->vendingData->tokenDec;
                        return response()->json(route('feedback', ['status' => 'error', 'msg' => $message]));
                    }
                    $error = "Service not available,  Visit Transaction page to confirm service (Login is require)";
                    return redirect()->route('feedback', ['status' => 'error', 'msg' => $error]);

                }
            } else {
                $vendTran = new VendingTransaction();
                $vendTran->meterPan = $meterPAN;
                $vendTran->merchant_id = $merchantId;
                $vendTran->amount = $amount;
                $vendTran->vend_value = $vend_amt;
                $vendTran->txref = $txID;
                $vendTran->response = json_encode($resp);
                $vendTran->verified = false;

                $vendTran->save();
                if ($path == 2) {
                    return redirect()->route('power.manage')->with("error", "Vending service not available,  Visit Transaction page to confirm service");
                }else if($path==4){
                    $message = "Vending service not available,  Visit Transaction page to confirm service";// . $response->vendingData->tokenDec;
                    return response()->json(route('feedback', ['status' => 'error', 'msg' => $message]));
                }
                $error = "Service not available,  Visit Transaction page to confirm service (Login is require)";
                return redirect()->route('feedback', ['status' => 'error', 'msg' => $error]);
            }
        } catch (\Throwable $th) {
            $vendTran = new VendingTransaction();
            $vendTran->meterPan = $meterPAN;
            $vendTran->merchant_id = $merchantId;
            $vendTran->amount = $amount;
            $vendTran->vend_value = $vend_amt;
            $vendTran->txref = $txID;
            $vendTran->response = json_encode(["Error occur"]);
            $vendTran->verified = false;

            $vendTran->save();
            \Log::info($th);
            if ($path == 2) {
                return redirect()->route('power.manage')->with("error", "Vending service not available,  Visit Transaction page to confirm service");
            }
            else if($path==4){
                $message = "Vending service not available,  Visit Transaction page to confirm service";// . $response->vendingData->tokenDec;
                return response()->json(route('feedback', ['status' => 'error', 'msg' => $message]));
            }
            $error = "Service not available,  Visit Transaction page to confirm service (Login is require)";
            return redirect()->route('feedback', ['status' => 'error', 'msg' => $error]);
        }

    }

    public function VendonCredit($request,$merchant)
    {
        $email = $request['email'];
        $phone = $request['phone'];
        $name = $request['name'];
        $meter = $request['meternumber'];
        $path = $request['path'];
        $amount = $request['amount'];
        $txID = Paystack::genTranxRef();
        $vend_amt = $amount;
        $role = 3;
        $meteruser = estateuser::where('meternumber', $meter)->first();
        $setting = Setting::where('manager_user_id', $meteruser->manager_user_id)->first();
        if($setting->creditvending==0){
            return redirect()->route('power.manage')->with("info", "Credit Vending Not Allowed"); 
        }
        
        if($amount > $setting->maxcreditamount){
            return redirect()->route('power.manage')->with("info", "Max Credit Vending Amount is ". $setting->maxcreditamount); 
        }
    
        
        $creditpercent = $setting->on_credit_fee;
        $diesel_deposite =false;
        $diesel_amount = 0;
      
        if (Auth::user()->role == 4) {
            $role = 4;
            $creditfee = $amount * ($creditpercent / 100);
            $vend_amt = $vend_amt - ($creditfee+100);
        }
        try {
            $parameter = [];
            $url = config('hinge.hingeurl') . "vend_token";
            $parameter['access_key'] = config('hinge.hingekey');
            $parameter['meterpan'] = $meter;
            $parameter['amount'] = $vend_amt;
            $parameter['txref'] = $txID;
            $parameter['role'] = $role;
            $resp = Http::withOptions(["verify" => true])
                ->post($url, $parameter);

            if ($resp["status"] == "ok") {
                $response = json_decode($resp["msg"]);
                if ($response->statusCode == "0") {
                    $vend_channel = 0;
                    $credit = 1;
                    $meteruser = estateuser::where('meternumber', $meter)->first();
                    $phone = $meteruser->phonenumber;
                    $email = User::where('id', $meteruser->user_id)->value('email');
                    $payerid = $meteruser->user_id;
                    $creditpurchase = new CreditPurchase();
                    $creditpurchase->user_id = Auth::id();
                    $creditpurchase->meternumber = $meter;
                    $creditpurchase->transaction_id = $txID;
                    $creditpurchase->service_type = 0;
                    $creditpurchase->amount = $amount;
                    $creditpurchase->amt_to_pay = $amount;
                    $creditpurchase->pay_status = 0;
                    $creditpurchase->transaction_date = Carbon::now();
                    $creditpurchase->save();
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meter;
                    $vendTran->merchant_id = $merchant;
                    $vendTran->amount = $amount;
                    $vendTran->vend_channel = $vend_channel;
                    $vendTran->vend_value = $vend_amt;
                    $vendTran->purchase_type = $credit;
                    $vendTran->txref = $txID;
                    $vendTran->response = json_encode($response->vendingData);
                    $vendTran->token = $response->vendingData->tokenDec;
                    $vendTran->tokenHex = $response->vendingData->tokenHex;
                    $vendTran->tariff = $response->vendingData->tariff;
                    $vendTran->unitsActual = $response->vendingData->unitsActual;
                    $vendTran->verified = true;
                    $vendTran->save();
                    $message = "Purchase successfull, here is your token: " . $response->vendingData->tokenDec;
                    $helper = new HelperClass();
                    // $helper->sendSMS($phone, $message);
                    $notify = new Notification();
                    $notify->user_id = $payerid;
                    $notify->type = 0;
                    $notify->notify_msg = $response->vendingData->unitsActual . "kwH power unit  purchased successfully. Token: " . $response->vendingData->tokenDec;
                    $notify->save();

                    return redirect()->route('power.manage')->with("success", "Purchase successfull, here is your token: " . $response->vendingData->tokenDec);

                } else {
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meter;
                    $vendTran->merchant_id = $merchant;
                    $vendTran->amount = $amount;
                    $vendTran->txref = $txID;
                    $vendTran->response = json_encode($response);
                    $vendTran->verified = false;
                    $vendTran->save();
                    return redirect()->route('power.manage')->with("error", "Vending service not available, try again");
                }
            } elseif ($resp->status == "info") {
                $msg = $resp->msg;
                return redirect()->route('power.manage')->with("error", $msg . " Contact the your administration ");
            } else {
                return redirect()->route('power.manage')->with("error", "Error occur, try again later!!! ");
            }

        } catch (\Throwable $th) {
            \Log::info($th);
            $vendTran = new VendingTransaction();
            $vendTran->meterPan = $meter;
            $vendTran->merchant_id = $merchant;
            $vendTran->amount = $amount;
            $vendTran->txref = $txID;
            $vendTran->response = json_encode(["Error occur"]);
            $vendTran->verified = false;
            $vendTran->save();
            return redirect()->route('power.manage')->with("error", " Error Occur");
        }

    }

    public function VendVerify($txID)
    {
        $getTrans = PaymentTransact::where('txref', $txID)
            ->where('category', 0)
            ->where('payment_status', 'successful')
            ->first();
        if ($getTrans) {
            $eUser = estateuser::where('user_id', $getTrans->payerid)->first();
            $email = $eUser->user->email;
            $meter = $eUser->meternumber;
            $merchant = $eUser->manager_user_id;
            if ($getTrans->service_status == true || $getTrans->service_status == 1) {
                $vendTran = VendingTransaction::where('txref', $txID)->first();
                return redirect()->back()->with("info", "Your vending was initally successfull, here is your token: " . $vendTran->token);
            }
        }
        $getTrans = PaymentTransact::where('txref', $txID)
            ->where('category', 0)
            ->first();
        $amount = $getTrans->amount;
        $vendamount = $getTrans->vend_value;

        try {
            $parameter = [];
            $url = config('hinge.hingeurl') . "revend_token";
            $parameter['access_key'] = config('hinge.hingekey');
            $parameter['meterpan'] = $meter;
            $parameter['amount'] = $vendamount;
            $parameter['transaction_ref'] = $txID;
            $resp = Http::withOptions(["verify" => true])
                ->post($url, $parameter);
            if ($resp["status"] == "ok") {
                $response = json_decode($resp["msg"]);
                if ($response->statusCode == "0") {
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meter;
                    $vendTran->merchant_id = $merchant;
                    $vendTran->amount = $amount;
                    $vendTran->vend_value = $vendamount;
                    $vendTran->purchase_type = 1;
                    $vendTran->txref = $txID;
                    $vendTran->response = json_encode($response->vendingData);
                    $vendTran->token = $response->vendingData->tokenDec;
                    $vendTran->tokenHex = $response->vendingData->tokenHex;
                    $vendTran->tariff = $response->vendingData->tariff;
                    $vendTran->unitsActual = $response->vendingData->unitsActual;
                    $vendTran->verified = true;
                    $vendTran->save();
                    $getTrans = PaymentTransact::where('txref', $txID)->first();
                    $getTrans->charged_amt = $amount - $vendamount;
                    $getTrans->service_status = true;
                    $getTrans->update();
                    $helper = new HelperClass();
                    $vendTran->charges = $amount - $vendamount;
                    $helper->sendEmailUser($email, "Token Purchase", $vendTran);
                    $notify = new Notification();
                    $notify->user_id = $getTrans->payerid;
                    $notify->type = 0;
                    $notify->notify_msg = $response->vendingData->unitsActual . "kwH power unit  purchased successfully. Token: " . $response->vendingData->tokenDec;
                    $notify->save();
                    return redirect()->back()->with("success", "Purchase successfull, here is your token: " . $response->vendingData->tokenDec);

                } else {
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meter;
                    $vendTran->merchant_id = $merchant;
                    $vendTran->amount = $amount;
                    $vendTran->txref = $txID;
                    $vendTran->response = json_encode($response);
                    $vendTran->verified = false;
                    $vendTran->save();
                    return redirect()->back()->with("error", "Vending service not available, try again");
                }
            } else if ($resp->status == "okv") {
                $response = json_decode($resp->msg);
                if ($response->statusCode == "0") {
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meter;
                    $vendTran->merchant_id = $merchant;
                    $vendTran->txref = $txID;
                    $vendTran->amount = $amount;
                    $vendTran->vend_value = $vendamount;
                    $vendTran->response = json_encode($response);
                    $vendTran->token = $response->tokenDec;
                    $vendTran->tokenHex = $response->tokenHex;
                    $vendTran->tariff = $response->tariff;
                    $vendTran->unitsActual = $response->unitsActual;
                    $vendTran->verified = true;
                    $vendTran->save();
                    $getTrans = PaymentTransact::where('txref', $txID)->first();
                    $getTrans->charged_amt = $amount - $vendamount;
                    $getTrans->service_status = true;
                    $getTrans->update();
                    return redirect()->back()->with("success", "Purchase successfull, here is your token: " . $response->tokenDec);

                } else {
                    return redirect()->back()->with("success", "Vending service not available, try again");
                }

            } else {
                return redirect()->back()->with("error", "Vending service not available, try again");
            }

        } catch (\Throwable $th) {
            \Log::info("Vending error :".$th);
            return redirect()->back()->with("error", "Vending service not available, try again");
        }

    }

    
    public function AdminVend(Request $request)
    {
        $estateuser = estateuser::where('meternumber', $request->meternumber)->first();
        if ($estateuser) {
            $requestCode = Str::random(8);
            $adminvend = new AdminVend();
            $adminvend->requestcode = $requestCode;
            $adminvend->amount = $request->amount;
            $adminvend->meter = $request->meternumber;
            $adminvend->channel = $request->channel;
            $adminvend->status = false;
            $adminvend->save();
            $email ="bumsyyd@gmail.com";
            $estate_name= Estate::where('manager_user_id',$estateuser->manager_user_id)->value('name');
            $data = ['name' => $estateuser->user->name, 'estate' => $estate_name, 'housenum' => $estateuser->housenum, 'amount' => $request->amount,'code'=>$requestCode];
            HelperClass::AdminVend($email,$data);
            return redirect()->back()->with("success", "Request sent to super admin, transaction will automatically be complete once request is approved");
        } else {
            return redirect()->back()->with("error", "Meter not found. Confirm meter number");
        }
    }


    public function ViewHistory(Request $request)
    {
        $user = Auth::user();
        $estateuser = $user->estateuser;
        $meterpan = "";
        if ($estateuser) {
            $meterpan = $estateuser->meternumber;
        }
        return view('resident.powermanage', compact('meterpan'));
    }

    public function getMeter(Request $request)
    {
        $phone = "";
        $email = "";
        $first = "";
        $last = "";
        $meteruser = estateuser::where('estate_id', $request->estateid)->where('housenum', $request->housenumber)->first();
        if ($meteruser) {
            $phone = $meteruser->phonenumber;
            $user = User::where('id', $meteruser->user_id)->first();
            $name = $user->name;
            $email = $user->email;
            $firstlast = explode(" ", $name);
            if (count($firstlast) > 1) {
                $first = $firstlast[0];
                $last = $firstlast[1];
            } else {
                $first = $firstlast[0];
                $last = $firstlast[0];
            }
            return \response()->json(['status' => 'ok', 'email' => $email, 'phone' => $phone,
            "firstName" => $first, "lastName" => $last, 'meternumber' => $meteruser->meternumber,'isdiesel'=>false,'isdiesel'=>false]);
        } else {
            return \response()->json(['status' => 'notfound', 'email' => "", 'phone' => "", 'meternumber' => "", "firstName" => $first, "lastName" => $last]);
        }

    }

    public function PowerDetails(Request $request)
    {
        $user = Auth::user();
        $from = $request->start_date;
        $to = $request->end_date;
        $transactions = array();
        $data = [];
        $index = 0;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        $meter = $user->estateuser->meternumber;
        if ($from == $today && $to == $today) {
            $transactions = VendingTransaction::where('meterPan', $user->estateuser->meternumber)->where('verified', 1)
                ->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();

        } else if ($from == $yesterday && $to == $yesterday) {
            $transactions = VendingTransaction::where('meterPan', $user->estateuser->meternumber)->where('verified', 1)
                ->whereDate('created_at', $yesterday)->orderBy('id', 'desc')->get();
        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $transactions = VendingTransaction::where('meterPan', $user->estateuser->meternumber)->where('verified', 1)
                ->whereBetween('created_at', $this_month)->orderBy('id', 'desc')->get();
        }
        foreach ($transactions as $key => $value) {
            # code...
            $value->transdate = \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:m:s');
             if($value->purchase_type == 1){
                {
                    $creditpurchase = CreditPurchase::where('meternumber', $value->meterPan)->orderBy('id', 'desc')->first();
                    if($creditpurchase){
                        if($creditpurchase->pay_status == 1){
                            $value->purchase_type = 0; 
                        }
                    }
                }
            }
        }
        return DataTables::of($transactions)
            ->make(true);
    }

    public function PowerStat(Request $reuest)
    {
        $user = Auth::user();
        $creditpurchase = CreditPurchase::where('meternumber', $user->estateuser->meternumber)->where('service_type', 0)->where('pay_status', 0)->orderBy('id', 'desc')->sum('amt_to_pay');
        if ($creditpurchase == null) {$creditpurchase = 0;}
        $lastvending = VendingTransaction::where('meterPan', $user->estateuser->meternumber)->where('verified', 1)->orderBy('id', 'desc')->first();
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $this_month = [$start, $end];
        $alltimepurchse = VendingTransaction::where('meterPan', $user->estateuser->meternumber)->where('verified', 1)->whereBetween('created_at', $this_month)->sum('amount');

        return response()->json([
            "status" => "true",
            "creditpurchase" => $creditpurchase,
            "lastvending" => $lastvending,
            "alltimepurchse" => $alltimepurchse,
        ]);

    }

    public function PowerBuy(Request $request)
    {
        return view('purchase');

    }
    public function getHistory(Request $request)
    {
        $user = Auth::user();
        $from = $request->start_date;
        $to = $request->end_date;
        $transactions = array();
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        if ($user->estateuser) {
            $meter = $user->estateuser->meternumber;
            if ($from == $today && $to == $today) {
                $transactions = PaymentTransact::where("payment_transacts.payerid", $meter)->where('payment_status', 'successful')->whereDate('payment_transacts.created_at', Carbon::today())
                    ->rightJoin('vending_transactions', 'vending_transactions.txref', 'payment_transacts.txref')->orderBy('payment_transacts.id', 'desc')
                    ->select('vending_transactions.*', 'payment_transacts.amount as vendamt')->get();
                //  dd($transactions);
            } else if ($from == $yesterday && $to == $yesterday) {
                $transactions = PaymentTransact::where("payment_transacts.payerid", $meter)->where('payment_status', 'successful')->whereDate('payment_transacts.created_at', $yesterday)
                    ->rightJoin('vending_transactions', 'vending_transactions.txref', 'payment_transacts.txref')->orderBy('payment_transacts.id', 'desc')
                    ->select('vending_transactions.*', 'payment_transacts.amount as vendamt')->get();
            } else {
                $start = Carbon::parse($from);
                $end = Carbon::parse($to)->addDay();
                $this_month = [$start, $end];
                $transactions = PaymentTransact::where("payment_transacts.payerid", $meter)->where('payment_status', 'successful')->whereBetween('payment_transacts.created_at', $this_month)
                    ->rightJoin('vending_transactions', 'vending_transactions.txref', 'payment_transacts.txref')->orderBy('payment_transacts.id', 'desc')
                    ->select('vending_transactions.*', 'payment_transacts.amount as vendamt')->get();

            }
            foreach ($transactions as $key => $value) {
                # code...
                $value->transdate = \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:m:s');
                 if($value->purchase_type == 1){
                {
                    $creditpurchase = CreditPurchase::where('meternumber', $value->meterPan)->orderBy('id', 'desc')->first();
                    if($creditpurchase){
                        if($creditpurchase->pay_status == 1){
                            $value->purchase_type = 0; 
                        }
                    }
                }
            }
            }

        }

        return DataTables::of($transactions)
            ->make(true);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PowerManager  $powerManager
     * @return \Illuminate\Http\Response
     */
    public function show(PowerManager $powerManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PowerManager  $powerManager
     * @return \Illuminate\Http\Response
     */
    public function edit(PowerManager $powerManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PowerManager  $powerManager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PowerManager $powerManager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PowerManager  $powerManager
     * @return \Illuminate\Http\Response
     */
    public function destroy(PowerManager $powerManager)
    {
        //
    }

    public function loadpowerstat(Request $request)
    {
        $user = Auth::user();
        $emanager = $user->name;
        $from = $request->start_date;
        $to = $request->end_date;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        $thisyear = [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()->addDay()];
        $this_month = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->addDay()];
        $tmeter = estateuser::where('estateusers.manager_user_id', $user->id)->count();
        $yearamt = VendingTransaction::where('vending_transactions.verified', 1)
            ->whereBetween('vending_transactions.created_at', $thisyear)
            ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
            ->where('estateusers.manager_user_id', $user->id)
            ->sum('vend_value');

        $monthamt = VendingTransaction::where('vending_transactions.verified', 1)
            ->whereBetween('vending_transactions.created_at', $this_month)
            ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
            ->where('estateusers.manager_user_id', $user->id)
            ->sum('vend_value');

        if ($from == $today && $to == $today) {
            $query = VendingTransaction::where('vending_transactions.verified', 1)
                ->whereDate('vending_transactions.created_at', $today)
                ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
                ->where('estateusers.manager_user_id', $user->id)
                ->sum('vend_value');
        } else if ($from == $yesterday && $to == $yesterday) {
            $query = VendingTransaction::where('vending_transactions.verified', 1)
                ->whereDate('vending_transactions.created_at', $yesterday)
                ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
                ->where('estateusers.manager_user_id', $user->id)
                ->sum('vend_value');
        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $range = [$start, $end];
            $query = VendingTransaction::where('vending_transactions.verified', 1)
                ->whereBetween('vending_transactions.created_at', $range)
                ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
                ->where('estateusers.manager_user_id', $user->id)
                ->sum('vend_value');
        }
        return response()->json([
            "status" => "true",
            "meter" => $tmeter,
            "yearamt" => $yearamt,
            "monthamt" => $monthamt,
            "query" => $query,
        ]);
    }

    public function getVendTransactions(Request $request)
    {
        $user = Auth::user();
        $from = $request->start_date;
        $to = $request->end_date;
        $data = [];
        $index = 0;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        if ($from == $today && $to == $today) {
            $transactions = VendingTransaction::where('vending_transactions.verified', 1)
                ->whereDate('vending_transactions.created_at', $today)
                ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
                ->where('estateusers.manager_user_id', $user->id)
                ->join('users', 'users.id', 'estateusers.user_id')
                ->select('vending_transactions.*', 'users.name', 'estateusers.housenum')
                ->orderBy('id', 'desc')->get();

        } else if ($from == $yesterday && $to == $yesterday) {
            $transactions = VendingTransaction::where('vending_transactions.verified', 1)
                ->whereDate('vending_transactions.created_at', $yesterday)
                ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
                ->where('estateusers.manager_user_id', $user->id)
                ->join('users', 'users.id', 'estateusers.user_id')
                ->select('vending_transactions.*', 'users.name', 'estateusers.housenum')
                ->orderBy('id', 'desc')->get();

        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $transactions = VendingTransaction::where('vending_transactions.verified', 1)
                ->whereBetween('vending_transactions.created_at', $this_month)
                ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
                ->where('estateusers.manager_user_id', $user->id)
                ->join('users', 'users.id', 'estateusers.user_id')
                ->select('vending_transactions.*', 'users.name', 'estateusers.housenum')
                ->orderBy('id', 'desc')->get();
        }
        foreach ($transactions as $key => $value) {
            # code...
            $value->transdate = \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:m:s');
             if($value->purchase_type == 1){
                {
                    $creditpurchase = CreditPurchase::where('meternumber', $value->meterPan)->orderBy('id', 'desc')->first();
                    if($creditpurchase){
                        if($creditpurchase->pay_status == 1){
                            $value->purchase_type = 0; 
                        }
                    }
                }
            }
        }

        return DataTables::of($transactions)
            ->make(true);
    }

    public function VendHistory(Request $request)
    {
        $from = $request->start_date;
        $to = $request->end_date;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        if (($from == $today && $to == $today) || ($from == $yesterday && $to == $yesterday)) {
            $transactions = VendingTransaction::where('vending_transactions.verified', 1)
                ->whereDate('vending_transactions.created_at', $from)
                ->join('managers', 'managers.user_id', 'vending_transactions.merchant_id')
                ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
                ->join('estates', 'estates.id', 'estateusers.estate_id')
                ->join('users', 'users.id', 'estateusers.user_id')
                ->select('vending_transactions.*', 'users.name as buyer', 'managers.name as manager', 'estates.name as estate')
                ->orderBy('id', 'desc')->get();

        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];

            $transactions = VendingTransaction::where('vending_transactions.verified', 1)
                ->whereBetween('vending_transactions.created_at', $this_month)
                ->join('managers', 'managers.user_id', 'vending_transactions.merchant_id')
                ->join('estateusers', 'estateusers.meternumber', 'vending_transactions.meterPan')
                ->join('estates', 'estates.id', 'estateusers.estate_id')
                ->join('users', 'users.id', 'estateusers.user_id')
                ->select('vending_transactions.*', 'users.name as buyer', 'managers.name as manager', 'estates.name as estate')
                ->orderBy('id', 'desc')->get();

        }
        foreach ($transactions as $key => $value) {
            # code...
            $value->transdate = \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:m:s');
             if($value->purchase_type == 1){
                {
                    $creditpurchase = CreditPurchase::where('meternumber', $value->meterPan)->orderBy('id', 'desc')->first();
                    if($creditpurchase){
                        if($creditpurchase->pay_status == 1){
                            $value->purchase_type = 0; 
                        }
                    }
                }
            }
        }

        return DataTables::of($transactions)
            ->make(true);
    }

    public function VendStat(Request $request)
    {
        $from = $request->start_date;
        $to = $request->end_date;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        if (($from == $today && $to == $today) || ($from == $yesterday && $to == $yesterday)) {
            $creditsale = VendingTransaction::where('verified', 1)
                ->where('vend_utility', 0)
                ->whereDate('created_at', $from)->sum('vend_value');
            $monthamt = VendingTransaction::where('verified', 1)
                ->where('vend_utility', 0)
                ->whereDate('created_at', $from)
                ->sum('vend_value');
            $revenue = Revenue::where('purchase_type', 0)->whereDate('created_at', $from)->sum('amount');
        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $creditsale = VendingTransaction::where('verified', 1)
                ->where('vend_utility', 0)
                ->whereBetween('created_at', $this_month)->sum('vend_value');
            $monthamt = VendingTransaction::where('verified', 1)
                ->where('vend_utility', 0)
                ->whereBetween('created_at', $this_month)
                ->sum('vend_value');
            $revenue = Revenue::where('purchase_type', 0)->whereBetween('created_at', $this_month)->sum('amount');

        }
        return response()->json([
            "revenue" => $revenue,
            "vmonth" => $monthamt,
            "credit" => $creditsale,
        ]);

    }

    public function webhook(Request $request)
    {
        $data = json_encode($request->all());
        \Log::info("Webhook");
        \Log::info($data);
        $webhook_response = json_decode($data, true);
        $reference = $webhook_response['data']['reference'];
        if ($webhook_response['event'] === "charge.success") {
           
        } else {
            return response()->json(404);

        }

    }
}