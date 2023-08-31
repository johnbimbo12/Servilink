<?php

namespace App\Http\Controllers;

use App\Helpers\HelperClass;

use App\Models\estateuser;
use App\Models\PaymentTransact;
use App\Models\Revenue;
use App\Models\DieselManager;
use App\Models\CreditPurchase;
use App\Models\Estate;
use App\Models\ServiceAccount;
use App\Models\Setting;
use App\Models\VendingTransaction;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Paystack;
use Redirect;

class CreditPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paycredit(Request $request)
    {
        $user = Auth::user();
        if(!$user){
             return view('resident.dashboard');
        }
        $creditpurchase = CreditPurchase::where('user_id', $user->id)->where('pay_status', 0)->orderBy('id', 'desc')->first();
        if (!$creditpurchase) {
            return redirect()->route('power.manage' )->with("info", "No outstanding payment");
        }
        $phone = $user->phone;
        $email = $user->email;
        $pay_amt = $creditpurchase->amt_to_pay;
        $amt = $creditpurchase->amount;
        $meternumber = $creditpurchase->meternumber;
        $diesel_deposite =false;
        $diesel_amount = 0;
        $reference = Paystack::genTranxRef();
        $estateuser = estateuser::where('meternumber', $meternumber)->first();
        $manager_user_id= $estateuser->manager_user_id;
        $estateaccount = ServiceAccount::where('manager_user_id', $manager_user_id)->where('service_type', 0)->value('subaccount_id');
        $trans_fee = Setting::where('manager_user_id', $manager_user_id)->first();
        $vendTran = VendingTransaction::where('txref', $creditpurchase->transaction_id)->orderBy('id', 'desc')->first();
        $managerfund = $vendTran->vend_value;
        $charge =$pay_amt-$managerfund-100;  // fund to platform
        $merchantamt = (int) $managerfund * 100;
        $diesel_deposite =false;
        $diesel_amount = 0;
         try {
            $diesel_deposit = DieselManager::where('meternumber', $meternumber)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->first();
            if ($diesel_deposit) {
            } else {
                $diesel_amount = Estate::where('id', $estateuser->estate_id)->value('diesel_deposit');
                $pay_amt =floatval($pay_amt) + $diesel_amount;
                $diesel_deposite = true;
            }
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
        }
        $helper = new HelperClass();
        $pTransfee = $helper->transactionfee($pay_amt);
        $amount2pay = ($pay_amt+ $pTransfee) * 100;
        $split = [
            "type" => "flat",
            "currency" => "NGN",
            "bearer_type" => "subaccount",
            "bearer_subaccount" => $estateaccount,
            "main_account_share" => $charge * 100,
            "subaccounts" => [
                ["subaccount" => $estateaccount, "share" => $merchantamt],
                ["subaccount" => "ACCT_66p7qa0yqzsyvve", "share" => 10000], //hinge share
            ],

        ];
        
        $metadata = [
            'email' => $email,
            "phonenumber" => $phone,
            'meternumber' => $meternumber,
            'charges' => $charge,
            'manager_id' => $manager_user_id,
            'user_id' => $user->id,
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
            'callback_url' =>route('credit.callback'),
        ];

        $request->request->add($data);
        try { //to ensure the page return back to the user when the session has expired

            $payerid = estateuser::where('meternumber', $meternumber)->value('user_id');
            $transact = new PaymentTransact();
            $transact->payerid = $payerid;
            $transact->merchant=  $manager_user_id;
            $transact->path = 2;
            $transact->amount = $pay_amt;
            $transact->customer = json_encode($metadata);
            $transact->txref = $reference;
            $transact->vend_value = $vendTran->vend_value;
            $transact->category = 3;
            $transact->service_status = 1;
            $transact->payment_status = "Processing";
            $transact->save();
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            \Log::info($e);
            $msg = "Payment service not available, try again later!!!";
            return redirect()->route('power.manage')->with("error", $msg);
        }
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {
        $response = Paystack::getPaymentData();
        $response_status = $response['status'];
        $response_msg = $response['message'];
        if ($response_status == true) {
            $response_data = $response['data'];
            $txID = $response_data['reference'];
            $transact = PaymentTransact::where("txref", $txID)->first();
            $request = json_decode($transact->customer);
            $transact->payment_status = "successful";
            $transact->charged_amt = $request->charges;
            $transact->update();
            try {
                $diesel_deposit = $request->diesel_deposite;
                $damount = $request->diesel_amount;
                if ($diesel_deposit == true) {
                    $dmanager = new DieselManager();
                    $dmanager->meternumber = $request->meternumber;
                    $dmanager->amount = $damount;
                    $dmanager->save();
                }
            } catch (\Throwable $th) {
                \Log::error($th);
            }
            $creditpurchase = CreditPurchase::where('user_id', $request->user_id)->where('pay_status', 0)->orderBy('id', 'desc')->first();
            if($creditpurchase){
                $creditpurchase->pay_status = 1;
                $creditpurchase->update();
                $vendTran = VendingTransaction::where('txref',  $creditpurchase->transaction_id)->first();
                $vendTran->purchase_type = 0;
                $vendTran->update();
    
                $revenue = new Revenue();
                $revenue->txref = $txID;
                $revenue->payerid = $transact->payerid;
                $revenue->manager_user_id = $request->manager_id;
                $revenue->amount = $request->charges;
                $revenue->purchase_type = 3;
                $revenue->save();
                $msg = "Payment successful";
                return redirect()->route('power.manage')->with("success", $msg);
            }else{
                 return redirect()->route('power.manage')->with("success", "Outstanding fee already cleared");
            }

        } else {

            // $txID =  $response_data['reference'];
            // $transact = PaymentTransact::where("txref", $txID)->first();
            // $transact->payment_status = "fail";
            // $transact->update();
            // $path = $transact->path;
            // $request = json_decode($transact->customer);
            $error = $response_msg;
            $message = "null";
            return redirect()->route('power.manage')->with("error", $msg);

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
     * @param  \App\Models\CreditPurchase  $creditPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(CreditPurchase $creditPurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CreditPurchase  $creditPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditPurchase $creditPurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CreditPurchase  $creditPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreditPurchase $creditPurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CreditPurchase  $creditPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreditPurchase $creditPurchase)
    {
        //
    }
}