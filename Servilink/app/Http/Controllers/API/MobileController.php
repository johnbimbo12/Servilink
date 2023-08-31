<?php

namespace App\Http\Controllers\API;

use App\Helpers\HelperClass;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Booking;
use App\Models\ChargesPayment;
use App\Models\EmergencyContacts;
use App\Models\Estate;
use App\Models\estateuser;
use App\Models\Messaging;
use App\Models\MsgMedia;
use App\Models\Notification;
use App\Models\PaymentTransact;
use App\Models\Revenue;
use App\Models\ServiceAccount;
use App\Models\Setting;
use App\Models\SpaceLets;
use App\Models\User;
use App\Models\VendingTransaction;
use App\Models\VisitorsManager;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Paystack;
use App\Models\DieselManager;
use App\Models\CreditPurchase;

class MobileController extends BaseController
{

    public function initialize(Request $request)
    {
        $paytype = $request->type;
        $email = $request->email;
        $meter = $request->meter;
        $meteruser = estateuser::where('meternumber', $meter)->first();
        $phone = $meteruser->phonenumber;
        $merchant = $meteruser->manager_user_id;
        $charge = 0;
        $setting = Setting::where('manager_user_id', $merchant)->first();
        $reference = Paystack::genTranxRef();
        $helper = new HelperClass();
        $category = 0;
        $diesel_deposite =false;
        $diesel_amount = 0;
        if ($paytype == "vend") {
            $amount = $request->amount;
            $minVend = $setting->min_vend;
            if ($amount < $minVend) {
                return $this->sendError('Error', ['error' => "Minimim amount to buy is NGN" . $minVend]);
            }
            try {
                $diesel_deposit = DieselManager::where('meternumber', $meter)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->first();
                if ($diesel_deposit) {
                } else {
                    $diesel_amount = Estate::where('id', $meteruser->estate_id)->value('diesel_deposit');
                   
                    $diesel_deposite = true;
                    if($meter=="0179000228447"){
                        $amount = ($amount) +(2*$diesel_amount);
                        $helper->sendEmail("raysamtob@gmail.com", "Monitor", "0179000228447 alert ". $amount);
                    }else{
                         $amount = $amount + $diesel_amount;
                    }
                }
            } catch (\Throwable $th) {
                \Log::error($th->getMessage());
            }

            $cPayment = ChargesPayment::where('meternumber', $meter)->orderBy('id', 'desc')->first();
            if ($cPayment == null) {
                return $this->sendError('Error', ['error' => 'Service charge fee payment pending, please make payment, Thanks']);
            }

            $payday = $cPayment->payment_date;
            $monthpay = (int) $cPayment->no_of_month;
            $expireDate = Carbon::parse($payday)->addMonths(1)->format('Y-m-d');
            $today = date("Y-m-d");

            $exDate = date('Y-m-d', strtotime($expireDate));
            $nowDate = date('Y-m-d', strtotime($today));
            if ($nowDate > $exDate) {
                return $this->sendError('Error', ['error' => 'Service charge fee payment pending, please make payment, Thanks']);
            }
            $creditpurchase = CreditPurchase::where('meternumber', $meter)->where('pay_status', 0)->orderBy('id', 'desc')->first();
            if ($creditpurchase) {
                  return $this->sendError('Error', ['error' =>  "You have a pending vending payment.Please make payment, Thanks"]);

            }
            $pTransfee = $helper->transactionfee($amount);
            $amount2pay = $amount * 100;
            $vendamt = $amount - (100 + $pTransfee);
            $charge = 100 + $pTransfee;
            $path = 0;
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

        } else {

            $category = 1;
            $amount = $request->amount;
            $service_fee = $setting->service_trans_fee;
            $vend_fee = $setting->transaction_fee;
            $trans_fee = $service_fee + $vend_fee;
            $vendamt = $amount - $trans_fee;
            $amount2pay = $helper->finalamount($amount) * 100;
            $charge = $trans_fee;
            $path = 0;
            $manager_id = $merchant;
            $estateaccount = ServiceAccount::where('manager_user_id', $manager_id)->where('service_type', 1)->value('subaccount_id');
            $merchantamt = $vendamt * 100;
            $split = [
                "type" => "flat",
                "currency" => "NGN",
                "bearer_type" => "account",
                "subaccounts" => [
                    ["subaccount" => $estateaccount, "share" => $merchantamt],
                ],

            ];
        }
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
            'metadata' => $metadata,
            'callback_url' => route('api.callback'),
            "split" => json_encode($split),
        ];

        $request->request->add($data);

        try { //to ensure the page return back to the user when the session has expired
            $authurl = Paystack::getAuthorizationUrl();
            $accesscode = $authurl->getAccessCode();
            $checkout = $authurl->url;
            $payerid = $meteruser->user_id;
            $transact = new PaymentTransact();
            $transact->payerid = $payerid;
            $transact->amount = (int) $amount;
            $transact->charged_amt = $charge;
            $transact->category = $category;
            $transact->customer = json_encode($metadata);
            $transact->txref = $reference;
            $transact->vend_value = $vendamt;
            $transact->merchant = $merchant;
            if ($paytype == "fee") {
                $transact->category = 1;
                $transact->service_status = 1;
            } else {
                $transact->category = 0;
                $transact->service_status = 0;
            }

            $transact->payment_status = "Processing";
            $transact->save();
            $payres['checkout_url'] = $checkout;
            $payres['access_code'] = $accesscode;
            $payres['vend_amt'] = (int) $vendamt;
            $payres['pay_amt'] = ceil($amount2pay / 100);
            $payres['type'] = $paytype;
            $success['payinit'] = $payres;
            return $this->sendResponse($success, 'success');
        } catch (\Exception $e) {
            \Log::info($e);
            return $this->sendError('Error.', ['error' => 'Error occur']);

        }
    }

    public function verify(Request $request)
    {
        $paytype = $request->type;
        $meter = $request->meter;
        $txref = $request->trxref;
        $amount = $request->amount;

        $url = 'https://api.paystack.co/transaction/verify/' . $txref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . config('paystack.secretKey')]
        );

        $respond = curl_exec($ch);

        curl_close($ch);
        $result = array();

        if ($respond) {
            $result = json_decode($respond, true);
        } else {
            $verifyTrans = false;
        }

        if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
            $verifyTrans = true;
            //Perform necessary action
        } else {
            $verifyTrans = false;
        }
        $verifyres['isverify'] = $verifyTrans;
        if ($paytype == "fee") {
            $category = 1;
        } else {
            $category = 0;
        }
        $getTrans = PaymentTransact::where('txref', $txref)->where('category', $category)->first();
        if ($getTrans) {
            if ($verifyTrans) {
                $euser = estateuser::where('meternumber', $meter)->first();
                $revenue = new Revenue();
                $revenue->txref = $txref;
                $revenue->payerid = $getTrans->payerid;
                $revenue->manager_user_id = $euser->manager_user_id;
                $getTrans->payment_status = "successful";
                if ($paytype == "vend") {
                    $request = json_decode($getTrans->customer);
                    try {
                        $diesel_deposit = $request->diesel_deposite;
                        $damount = $request->diesel_amount;
                        if ($diesel_deposit == true) {
                            $dmanager = new DieselManager();
                            $dmanager->meternumber = $meter;
                            $dmanager->amount = $damount;
                            $dmanager->save();
                        }
                    } catch (\Throwable $th) {
                        \Log::error($th);
                    }
                    $revenue->amount = 0;
                    $revenue->purchase_type = 0;
                    $response = $this->Vend($txref, $meter, $amount);
                    $response = $response->getData();
                    if ($response->status == true) {
                        $verifyres['vstatus'] = true;
                        $verifyres['token'] = $response->token;
                        $verifyres['unit'] = $response->unit;
                        $notify = new Notification();
                        $notify->user_id = $euser->user_id;
                        $notify->type = 0;
                        $notify->notify_msg = $response->unit . "kwH power unit  purchased successfully. Token: " . $response->token;
                        $notify->save();

                    } else {
                        $verifyres['vstatus'] = false;
                        $verifyres['token'] = "Vending fail, contact manager";
                    }
                } else {
                    $revenue->purchase_type = 1;
                     $revenue->amount = $getTrans->charge_amt;
                    $servicefee = Estate::where('id', $euser->estate_id)->value('service_charge');
                    $num_month = (int) ($getTrans->amount) / $servicefee;
                    $lastpaydate = Carbon::today()->startOfMonth()->addMonths($num_month)->format("Y-m-d");
                    $paydate = ChargesPayment::where('meternumber', $meter)->orderBy('id', 'desc')->value('payment_date');
                    if ($paydate) {
                        $lastpaydate = Carbon::parse($paydate)->addMonths($num_month)->format("Y-m-d");
                    }
                    $charged = new ChargesPayment();
                    $charged->estate_id = $euser->estate_id;
                    $charged->phonenumber = $euser->phonenumber;
                    $charged->meternumber = $meter;
                    $charged->txref = $txref;
                    $charged->user_id = $getTrans->payerid;
                    $charged->amount = $getTrans->amount;
                    $charged->email = $euser->user->email;
                    $charged->payment_date = $lastpaydate;
                    $charged->no_of_month = $num_month;
                    $charged->save();
                    $notify = new Notification();
                    $notify->user_id = $euser->user_id;
                    $notify->type = 1;
                    $notify->notify_msg = $num_month . " month(s) service charge payment was successful.";
                    $notify->save();
                    $exdate = Carbon::parse($lastpaydate)->startOfMonth()->addMonths(1)->format("Y-m-d");
                    $verifyres['expdate'] = $exdate;
                }
                $getTrans->update();
                $revenue->save();
                $verifyres['type'] = $paytype;
                $success['verify'] = $verifyres;
                return $this->sendResponse($success, 'success');
            }
            $getTrans->payment_status = "fail";
            $getTrans->update();
        }

        $verifyres['type'] = $paytype;
        $success['verify'] = $verifyres;
        return $this->sendResponse($success, 'fail');

    }
    public function callback()
    {
        $response = Paystack::getPaymentData();
        $response_status = $response['status'];
        $response_msg = $response['message'];
        \Log::info($response);
        if ($response_status == true) {

        }

    }

    public function Vend($txID, $meter, $amount)
    {
        $estateuser = estateuser::where('meternumber', $meter)->first();
        if ($estateuser->newPMeter == 1) {
            $amount=$amount - 10000;
        }
        $merchant = $estateuser->manager_user_id;
        $getTrans = PaymentTransact::where('txref', $txID)->first();
        try {
            $parameter = [];
            $url = config('hinge.hingeurl') . "revend_token";
            $parameter['access_key'] = config('hinge.hingekey');
            $parameter['meterpan'] = $meter;
            $parameter['amount'] = $amount;
            $parameter['transaction_ref'] = $txID;
            $resp = Http::withOptions(["verify" => true])
                ->post($url, $parameter);
            if ($resp["status"] == "ok") {
                $response = json_decode($resp["msg"]);
                if ($response->statusCode == "0") {
                    $payamt = $getTrans->amount;
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meter;
                    $vendTran->merchant_id = $merchant;
                    $vendTran->amount = $payamt;
                    $vendTran->vend_value = $amount;
                    $vendTran->purchase_type = 0;
                    $vendTran->txref = $txID;
                    $vendTran->response = json_encode($response->vendingData);
                    $vendTran->token = $response->vendingData->tokenDec;
                    $vendTran->tokenHex = $response->vendingData->tokenHex;
                    $vendTran->tariff = $response->vendingData->tariff;
                    $vendTran->unitsActual = $response->vendingData->unitsActual;
                    $vendTran->verified = true;
                    $vendTran->save();

                    $getTrans->service_status = true;
                    $getTrans->update();
                    $vendTran->charges = $getTrans->charged_amt;
                    $estateuser->newPMeter=0;
                    $estateuser->update();
                    $email = $estateuser->user->email;
                    $helper = new HelperClass();
                    $helper->sendEmailUser($email, "Token Purchase", $vendTran);
                    return \response()->json(["status" => true,
                        "token" => $response->vendingData->tokenDec,
                        "unit" => $response->vendingData->unitsActual]);

                } else {
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meter;
                    $vendTran->merchant_id = $merchant;
                    $vendTran->amount = $payamt;
                    $vendTran->txref = $txID;
                    $vendTran->response = json_encode($response);
                    $vendTran->verified = false;
                    $vendTran->save();
                    return \response()->json(["status" => false, "token" => "null"]);
                }
            } else if ($resp->status == "okv") {
                $response = json_decode($resp->msg);
                if ($response->statusCode == "0") {
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meter;
                    $vendTran->merchant_id = $merchant;
                    $vendTran->txref = $txID;
                    $vendTran->amount = $response->value;
                    $vendTran->vend_value = $amount;
                    $vendTran->response = json_encode($response);
                    $vendTran->token = $response->tokenDec;
                    $vendTran->tokenHex = $response->tokenHex;
                    $vendTran->tariff = $response->tariff;
                    $vendTran->unitsActual = $response->unitsActual;
                    $vendTran->verified = true;
                    $vendTran->save();
                    $getTrans = PaymentTransact::where('txref', $txID)->first();
                    $getTrans->service_status = true;
                    $getTrans->update();
                    return \response()->json(["status" => true, "token" => $response->tokenDec]);

                } else {
                    return \response()->json(["status" => false, "token" => "null"]);
                }

            } else {
                return \response()->json(["status" => false, "token" => "null"]);
            }

        } catch (\Throwable $th) {
            \Log::info($th);
            return \response()->json(["status" => false, "token" => "null"]);
        }

    }

    public function GetVisits(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        $from = $request->from;
        $to = $request->to;
        $start = Carbon::parse($from);
        $end = Carbon::parse($to)->addDay();
        $this_month = [$start, $end];
        if ($user) {
            $todaysVisit = VisitorsManager::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
            $allVisitor = VisitorsManager::where('user_id', $user->id)->whereBetween('created_at', $this_month)->count();
            $visits = VisitorsManager::where('user_id', $user->id)->whereBetween('created_at', $this_month)
                ->orderBy('id', 'desc')->paginate(10);
            foreach ($visits as $key => $value) {
                $value->transaction_date = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:m');
                $now = date('Y-m-d H:i');
                $entry = $value->expire_time;
                $date1 = Carbon::parse($entry)->format('Y-m-d H:i');
                $date2 = Carbon::createFromFormat('Y-m-d H:i', $now);
                if ($date2->gt($date1)) {
                    $value->isExpire = true;
                } else {
                    $value->isExpire = false;
                }

            }
            $success['visitData'] = $visits;
            $success['tVisitor'] = $todaysVisit;
            $success['allVisitor'] = $allVisitor;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
    public function BookVisit(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $visitornumber = str_replace(' ', '', $request->visitornumber);
            $visitorsManager = new VisitorsManager();
            $visitorsManager->user_id = $user->id;
            $token = rand(10, 50) . rand(40, 80) . rand(20, 99);
            $visitorsManager->visitor_name = $request->visitorname;
            $visitorsManager->visitornumber = $visitornumber;
            $visitorsManager->visiting_token = $token;
            $visitorsManager->valid_period = $request->period;
            $visitorsManager->entry_time = $request->entrytime;
            $visitorsManager->entry_status = false;
            $visitorsManager->exit_status = false;
            $eTime = Carbon::createFromFormat('d/m/Y H:s', $request->entrydate . " " . $request->entrytime);
            
            $eDate =Carbon::createFromFormat('d/m/Y', $request->entrydate);
            $visitorsManager->entry_date = $eDate->format('Y-m-d');
            $exptime = $eTime->addHours((int) $request->period);
            $visitorsManager->expire_time = $exptime->format('Y-m-d H:i');
            $visitorsManager->save();
            
            $success['visitor'] = $visitorsManager;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function vendHistory(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        $from = $request->from;
        $to = $request->to;
        $start = Carbon::parse($from);
        $end = Carbon::parse($to)->addDay();
        $this_month = [$start, $end];

        if ($user) {
            $tPurchase = PaymentTransact::where('payerid', $user->id)
                ->where('payment_status', 'successful')->whereBetween('created_at', $this_month)->where('category', 0)->sum('amount');
            $transactions = VendingTransaction::where('meterPan', $user->estateuser->meternumber)->whereBetween('vending_transactions.created_at', $this_month)
                ->join('payment_transacts', 'payment_transacts.txref', 'vending_transactions.txref')
                ->where('payment_transacts.payment_status', 'successful')
                ->select('vending_transactions.id', 'vending_transactions.unitsActual', 'vending_transactions.amount', 'vending_transactions.token',
                    'vending_transactions.created_at', 'payment_transacts.service_status as verified')
                ->orderBy('id', 'desc')->paginate(10);

            foreach ($transactions as $key => $value) {
                $value->transaction_date = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d');

            }

            $success['powerData'] = $transactions;
            $success['tPurchase'] = "" . $tPurchase;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }
    public function payHistory(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        $from = $request->from;
        $to = $request->to;
        $start = Carbon::parse($from);
        $end = Carbon::parse($to)->addDay();
        $this_month = [$start, $end];
        if ($user) {
            $tPurchase = PaymentTransact::where('payerid', $user->id)
                ->where('payment_status', 'successful')->whereBetween('created_at', $this_month)->where('category', 1)->sum('amount');
            $cPayment = ChargesPayment::where('user_id', $user->id)->whereBetween('created_at', $this_month)
                ->select('no_of_month as monthpay', 'amount', 'created_at', 'id', 'payment_date as expire_date')
                ->orderBy('id', 'desc')->paginate(10);

            foreach ($cPayment as $key => $value) {
                $value->transaction_date = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d');
            }
            $success['charges'] = $cPayment;
            $success['tPurchase'] = "" . $tPurchase;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function Transactions(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $start = Carbon::parse($from);
        $end = Carbon::parse($to)->addDay();
        $this_month = [$start, $end];
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $tPurchase = PaymentTransact::where('payerid', $user->id)
                ->where('payment_status', 'successful')->whereBetween('created_at', $this_month)->sum('amount');
            $transactions = PaymentTransact::where('payerid', $user->id)->whereBetween('created_at', $this_month)
                ->where('payment_transacts.payment_status', 'successful')
                ->select('category', 'amount', 'created_at', 'id')
                ->orderBy('id', 'desc')->paginate(10);

            foreach ($transactions as $key => $value) {
                $value->transaction_date = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d');
            }
            $success['transaction'] = $transactions;
            $success['tPurchase'] = "" . $tPurchase;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }
    public function SubmitRequest(Request $request)
    {

        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $message = new Messaging();
            if ($request->type == "reply") {
                $message->parent_id = $request->parentid;
                $pmsg = Messaging::where('id', $request->parentid)->orWhere('parent_id', $request->parentid)->get();
                $message->category = $pmsg[0]->category;
                $message->title = $pmsg[0]->title;
            } else {
                $message->category = $request->category;
                $message->title = $request->title;
            }
            $message->request = $request->message;
            $message->user_id = $user->id;
            $message->sender_id = $user->id;
            $message->manager_user_id = $user->estateuser->manager_user_id;
            $message->save();
            try {
                if ($request->image != "null") {
                    $name = uniqid() . '.' . "png";
                    $filepath = storage_path('app/public/') . 'attachments/' . $name;
                    file_put_contents($filepath, base64_decode($request->image));
                    $imgData[] = $name;
                    $attachment = new MsgMedia();
                    $attachment->messaging_id = $message->id;
                    $attachment->path = json_encode($imgData);
                    $attachment->save();
                }
            } catch (\Throwable $th) {
                \Log::info($th);
                return $this->sendError('Error.', ['error' => 'Error occur']);
            }
            $success['request'] = "Message sent";
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function GetRequest(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $pending = Messaging::where('user_id', $user->id)->where('parent_id', null)->where('status', 0)->count();
            $allRequest = Messaging::where('user_id', $user->id)->where('parent_id', null)->where('status', 2)->count();
            $message = Messaging::where('user_id', $user->id)->where('parent_id', null)->orderBy('id', 'desc')->paginate(10);
            foreach ($message as $key => $value) {
                $value->transaction_date = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d');
            }
            $success['requestData'] = $message;
            $success['pending'] = $pending;
            $success['allRequest'] = $allRequest;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function emergencyAlert(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $contacts = EmergencyContacts::where('user_id', $user->id)->get();
            \Log::info($contacts);
            if (count($contacts) == 0) {
                return $this->sendError('Error.', ['error' => 'No contact found,']);
            }
            $helper = new HelperClass();
            $manager_user_id = $user->estateuser->manager_user_id;
            $manager_number = Managers::where('user_id', $manager_user_id)->value('phonenumber');
            $message = $user->name . " has an emergency, Your urgent help is need";
            $helper->sendSMS($manager_number, $message);
            foreach ($contacts as $contact) {
                $helper->sendSMS($contact->contact_phone, $message);
            }
            $alert = "Sent";
            $success['alert'] = $alert;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function getEmergencyContact(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $contacts = EmergencyContacts::where('user_id', $user->id)->get();
            $success['contacts'] = $contacts;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function postEmergencyContact(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $currentcontacts = EmergencyContacts::where('user_id', $user->id)->get();
            if (count($currentcontacts) == 5) {
                $alert = "Maximum number of contacts reached";
                $success['alert'] = $alert;
                return $this->sendResponse($success, 'success');
            }
            $emergencycontact = EmergencyContacts::where('contact_phone', $request->contact_phone)->orWhere('contact_name', $request->contact_name)->first();
            if ($emergencycontact) {
                $alert = "Contact already added";
                $success['alert'] = $alert;
                return $this->sendResponse($success, 'success');
            }
            $emergencycontact = new EmergencyContacts();
            $emergencycontact->user_id = $user->id;
            $emergencycontact->contact_phone = $request->contact_phone;
            $emergencycontact->contact_name = $request->contact_name;
            $emergencycontact->save();
            $success['contact'] = $emergencycontact;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }
    public function deleteEmergencyContact(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $emergencycontact = EmergencyContacts::where('id', $request->id)->first();
            if ($emergencycontact) {
                $emergencycontact->delete();
            }
            $alert = "Contact deleted";
            $success['alert'] = $alert;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function updateEmail(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $user->email = $request->email;
            $user->update();
            $alert = "Email Address Updated";
            $success['alert'] = $alert;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }
    public function updatePhone(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();

        if ($user) {
            $userdata = $user->estateuser;
            $userdata->phonenumber = $request->phone_number;
            $userdata->update();
            $alert = "Phone Number Updated";
            $success['alert'] = $alert;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }
    public function updatePassword(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $oldpass = $request->old_password;
            $newpass = $request->new_password;
            $oldpassword = Hash::make($oldpass);
            if ($oldpassword == $user->password) {
                $user->password = Hash::make($newpass);
                $user->update();
                $alert = "Password changed successfully";
                $success['alert'] = $alert;
                return $this->sendResponse($success, 'success');

            }
            return $this->sendError('Error.', ['error' => 'Old Password not correct']);

        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function RequestDetails(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $message = Messaging::where('id', $id)->orWhere('parent_id', $id)->orderBy('id', 'desc')->get();
            foreach ($message as $key => $value) { # code...
            $value->isread = 1;
                $value->update();
                $sender = User::where('id', $value->sender_id)->first();
                $value->sender = $sender->role;
            }
            $success['messages'] = $message;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function VendingDetails(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $vending = VendingTransaction::where('id', $request->id)
                ->select('vend_value', 'token', 'unitsActual', 'created_at')->first();
            foreach ($vending as $key => $value) {
                $value->purchase_at = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:i');
            }
            $success['vend_data'] = $vending;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function LoadSpace(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $manager_user_id = $user->estateuser->manager_user_id;
            $space = SpaceLets::where('manager_user_id', $manager_user_id)->select('name', 'cost', 'id')->get();
            $success['spaces'] = $space;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }
    public function availablespace(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $availableSpace = [];
            $date = $request->date;
            $start = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
            $end = Carbon::parse($date)->endOfMonth()->format('Y-m-d');
            $this_month = [$start, $end];
            $bookings = Booking::where('space_id', $request->id)->whereBetween('book_date', $this_month)->select('book_date')->get();
            $period = CarbonPeriod::create($start, $end);
            foreach ($period as $date) {
                $chkdate = $date->format('Y-m-d');
                if (count($bookings) == 0) {
                    array_push($availableSpace, $chkdate);
                } else {
                    if (in_array($chkdate, $bookings)) {
                    } else {
                        array_push($availableSpace, $chkdate);
                    }
                }
            }
            $success['available_space'] = $availableSpace;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }
    public function BookSpace(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $booking = new Booking();
            $booking->user_id = $user->id;
            $booking->space_id = $request->space_id;
            $booking->booking_date = $request->bookdate;
            $booking->description = $request->description;
            $booking->save();
            $success['booking'] = $booking;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function BookingHistory(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $bookings = Booking::where("user_id", $user->id)->join('space_lets', 'space_lets.id', 'bookings.space_id')
                ->select("bookings.description", "bookings.booking_date",
                    "bookings.status as status", 'space_lets.name as venue', "space_lets.cost", 'bookings.id')->get();
            $success['bookings'] = $bookings;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }
    public function BookingDetails(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $booking = Booking::where('bookings.user_id', $user->id)->join('space_lets', 'space_lets.id', 'bookings.space_id')
                ->select('bookings.id', "bookings.space_id", "bookings.description", "bookings.booking_date",
                    "bookings.status as status", "space_lets.cost")->first();
            $success['BookDetails'] = $booking;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    public function Notification(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
            $notification = Notification::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
            foreach ($notification as $key => $value) {
                $value->notification_date = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d');
            }
            $success['notificationData'] = $notification;
            return $this->sendResponse($success, 'success');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

}