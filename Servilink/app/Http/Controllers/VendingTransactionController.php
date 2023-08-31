<?php

namespace App\Http\Controllers;

use App\Helpers\HelperClass;
use App\Models\estateuser;
use App\Models\Notification;
use App\Models\PaymentTransact;
use App\Models\User;

use App\Models\AdminVend;
use App\Models\VendingTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Paystack;
use Redirect;

class VendingTransactionController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ConfirmAdminVending(Request $request)
    {
        $adminvend = AdminVend::where('requestcode', $request->requestcode)->where('status', false)->first();
        if ($adminvend) {
            $adminvend->status=true;
            $adminvend->update();
            $now = Carbon::now();
            $requestTime = $adminvend->created_at;
            $diff_in_minutes = $now->diffInMinutes($requestTime);
            
            if ($diff_in_minutes > 120) {
                return redirect()->route('feedback', ["status" => "error", "msg" => "Request time expire, kindly request for another request"]);
            }
            if((int)$request->status==2){
                $adminvend->status=true;
                $adminvend->update();
                return redirect()->route('feedback', ["status" => "error", "msg" => "Vend Request Declined"]); 
            }
        
            $meter = $adminvend->meter;
            $amount = $adminvend->amount;
            $paytype=(int)$adminvend->channel;
            if($paytype==1){
                 $amount = $amount - 300;
            }else{
                $helper = new HelperClass();
                $pTransfee = $helper->transactionfee($amount); //get payment fee
                $amount = $amount - (100 + $pTransfee);
            }
          
            $reference = Paystack::genTranxRef();
            $estateuser = estateuser::where('meternumber', $meter)->first();
            if ($estateuser->verified == 0) {
                try {
                    //code...
                    $params = [];
                    $url = config('hinge.hingeurl') . "check_meter";
                    $params['access_key'] = config('hinge.hingekey');
                    $params['meternumber'] = $meter;
                    $resp = Http::withOptions(["verify" => true])
                        ->post($url, $params);
                    $resp = json_decode($resp);
                    if ($resp->status == "ok") {
                        $response = json_decode($resp->msg);
                        if ($response->statusCode == "0") {
                            $estateuser->verified = 1;
                            $estateuser->update();
                        } else {
                            return redirect()->route('feedback', ["status" => "error", "msg" => "Meter verification fails. Contact your provider"]);
                        }

                    } else {
                        return redirect()->route('feedback', ["status" => "error", "msg" => "Meter verification fails. Contact your provider"]);

                    }

                } catch (\Throwable $th) {
                    return redirect()->route('feedback', ["status" => "error", "msg" => "Meter verification fails. Try again"]);
                }

            }
            $phone = $estateuser->phonenumber;
            $email = $estateuser->user->email;
            $payerid = $estateuser->user_id;
            $merchantId = $estateuser->manager_user_id;
            $metadata = [
                "meternumber" => $meter,
                "txref" => $reference,
                'email' => $email,
                'phone' => $phone,
            ];
            try {
                $parameter = [];
                $url = config('hinge.hingeurl') . "vend_token";
                $parameter['access_key'] = config('hinge.hingekey');
                $parameter['meterpan'] = $meter;
                $parameter['amount'] = $amount;
                $parameter['txref'] = $reference;
                $parameter['role'] = 2;
                $resp = Http::withOptions(["verify" => true])
                    ->post($url, $parameter);
                if ($resp["status"] == "ok") {
                    $response = json_decode($resp["msg"]);
                    if ($response->statusCode == "0") {
                        $transact = new PaymentTransact();
                        $transact->payerid = $payerid;
                        $transact->path = 3;
                        $transact->amount = (int) $amount;
                        $transact->charged_amt = 0;
                        $transact->customer = json_encode($metadata);
                        $transact->txref = $reference;
                        $transact->vend_value = $amount;
                        $transact->channel = 1;
                        $transact->merchant = $merchantId;
                        $transact->payment_status = "successful";
                        $transact->service_status = true;
                        $transact->save();
                        $adminvend->status = true;
                        $adminvend->update();
                        $vendTran = new VendingTransaction();
                        $vendTran->meterPan = $meter;
                        $vendTran->merchant_id = $merchantId;
                        $vendTran->amount = $amount;
                        $vendTran->vend_channel = 2;
                        $vendTran->vend_value = $amount;
                        $vendTran->txref = $reference;
                        $vendTran->response = json_encode($response->vendingData);
                        $vendTran->token = $response->vendingData->tokenDec;
                        $vendTran->tokenHex = $response->vendingData->tokenHex;
                        $vendTran->tariff = $response->vendingData->tariff;
                        $vendTran->unitsActual = $response->vendingData->unitsActual;
                        $vendTran->verified = true;
                        $vendTran->save();
                        $vendTran->charges = 0;
                        $estateuser->newPMeter = 0;
                        $estateuser->update();
                        $notify = new Notification();
                        $notify->user_id = $estateuser->user_id;
                        $notify->type = 0;
                        $notify->notify_msg = $response->vendingData->unitsActual . "kwH power unit  purchased successfully. Token: " . $response->vendingData->tokenDec;
                        $notify->save();
                        $message = "Purchase successfull, here is your token: " . $response->vendingData->tokenDec;
                        $helper = new HelperClass();
                        $helper->sendEmailUser($email, "Token Purchase", $vendTran);
                        return redirect()->route('feedback', ["status" => "success", "msg" => "Request Approved"]);

                    } else {
                        
                        if($resp["status"] == "info"){
                             return redirect()->route('feedback', ["status" => "error", "msg" =>$resp["msg"]]);
                        }
                        $vendTran = new VendingTransaction();
                        $vendTran->meterPan = $meter;
                        $vendTran->merchant_id = $merchantId;
                        $vendTran->amount = $amount;
                        $vendTran->vend_value = $amount;
                        $vendTran->txref = $reference;
                        $vendTran->response = json_encode($response);
                        $vendTran->verified = false;

                        $vendTran->save();
                        return redirect()->route('feedback', ["status" => "error", "msg" => "Vending service not available,  Visit Transaction page to confirm service"]);

                    }
                } else {
                    $vendTran = new VendingTransaction();
                    $vendTran->meterPan = $meter;
                    $vendTran->merchant_id = $merchantId;
                    $vendTran->amount = $amount;
                    $vendTran->vend_value = $amount;
                    $vendTran->txref = $reference;
                    $vendTran->response = json_encode($resp);
                    $vendTran->verified = false;
                    $vendTran->save();
                    return redirect()->route('feedback', ["status" => "error", "msg" => "Vending service not available,  Visit Transaction page to confirm service"]);

                }
            } catch (\Throwable $th) {
                $vendTran = new VendingTransaction();
                $vendTran->meterPan = $meter;
                $vendTran->merchant_id = $merchantId;
                $vendTran->amount = $amount;
                $vendTran->vend_value = $amount;
                $vendTran->txref = $reference;
                $vendTran->response = json_encode(["Error occur"]);
                $vendTran->verified = false;
                $vendTran->save();
                return redirect()->route('feedback', ["status" => "error", "msg" => "Vending service not available,  Visit Transaction page to confirm service"]);

            }
        } else {
            //request as been used
            return redirect()->route('feedback', ["status" => "error", "msg" => "Request already processed"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VendingTransaction  $vendingTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(VendingTransaction $vendingTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VendingTransaction  $vendingTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(VendingTransaction $vendingTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VendingTransaction  $vendingTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendingTransaction $vendingTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VendingTransaction  $vendingTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendingTransaction $vendingTransaction)
    {
        //
    }
}