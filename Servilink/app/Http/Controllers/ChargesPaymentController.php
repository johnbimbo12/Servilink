<?php

namespace App\Http\Controllers;

use App\Helpers\HelperClass;
use App\Models\ChargesPayment;
use App\Models\Estate;
use App\Models\estateuser;
use App\Models\Managers;
use App\Models\PaymentTransact;
use App\Models\Revenue;
use App\Models\ServiceAccount;
use App\Models\Setting;
use App\Models\User;
use App\Models\Notification;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Paystack;
use Redirect;

class ChargesPaymentController extends Controller
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
            $estates = Estate::select('name', 'service_charge', 'id')->get();
            $mName = Carbon::now()->format('F');
            $thismonth = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->addDay()];
            $mPayment = ChargesPayment::whereBetween('payment_date', $thismonth)->sum('amount');
            $paidnum = ChargesPayment::whereBetween('payment_date', $thismonth)->count();
            return view('manager.service_charge', compact('mName', 'mPayment', 'paidnum', 'estates'));
        } else if ($user->role == 4) {
            $servicefee = Estate::where('id', $user->estateuser->estate_id)->value('service_charge');
            $cPayment = ChargesPayment::where('user_id', $user->id)->orderBy('id', 'desc')->first();
            if ($cPayment) {
                $payday = $cPayment->payment_date;
                $expireDate = Carbon::parse($payday)->addMonths(1);
                $lastpayment = Carbon::parse($cPayment->created_at)->toFormattedDateString();
                $now = Carbon::now();
                $rDays = $expireDate->diffInDays($now);
            } else {
                $lastpayment = "No payment yet";
                $rDays = 0;

            }
            return view('resident.service_charge', compact('lastpayment', 'servicefee', 'rDays'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function initialize(Request $request)
    {

        $estate = $request->estateid;
        $paid_month = $request->nummonth;
        $phone = $request->phonenumber;
        $email = $request->email;
      
        $meternumber = $request->meternumber;

        $reference = Paystack::genTranxRef();
        $user = estateuser::where('meternumber', $meternumber)->first();
        $manager_user_id = $user->manager_user_id;
        $estateaccount = ServiceAccount::where('manager_user_id', $manager_user_id)->where('service_type', 1)->value('subaccount_id');
        $setting = Setting::where('manager_user_id', $manager_user_id)->first();
        $service_fee= $setting->service_trans_fee;
        $vend_fee= ($setting->transaction_fee)*$paid_month;
        $trans_fee = $service_fee+ $vend_fee;
        $pay_amt = $request->scamount ;
        $helper = new HelperClass();
        $amt2pay = $helper->finalamount($pay_amt) * 100;
        $vendamt =$pay_amt-$trans_fee;
        $merchantamt = ($vendamt) * 100;
        $split = [
            "type" => "flat",
            "currency" => "NGN",
            "bearer_type" => "account",
            "subaccounts" => [
                ["subaccount" => $estateaccount, "share" => $merchantamt],
            ],

        ];
        $metadata = [
            'email' => $email,
            "phonenumber" => $phone,
            'paid_month' => $paid_month,
            'estate' => $estate,
            'meternumber' => $meternumber,
            'fee' => $trans_fee,
            'manager_id' => $manager_user_id,
        ];
        $data = [
            'reference' => $reference,
            'email' => $email,
            'phone' => $phone,
            'amount' => $amt2pay,
            'currency' => 'NGN',
            'channels' => ['card', 'bank_transfer'],
            'metadata' => $metadata,
            "split" => json_encode($split),
            'callback_url' => route('service.callback'),

        ];

        $request->request->add($data);

        try { //to ensure the page return back to the user when the session has expired

            $payerid = $user->user_id;
            $transact = new PaymentTransact();
            $transact->payerid = $payerid;
            $transact->merchant = $manager_user_id;
            $transact->path = $request->path;
            $transact->amount = $pay_amt;
            $transact->charged_amt = $trans_fee;
            $transact->customer = json_encode($metadata);
            $transact->txref = $reference;
            $transact->vend_value = $vendamt;
            $transact->category = 1;
            $transact->service_status = 0;
            $transact->payment_status = "Processing";
            $transact->save();
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            \Log::info($e);
            if ($request->path == 0) {
                $msg = "Payment service not available, try again later!!!";
                return redirect()->route('feedback', ['status' => 'error', 'msg' => $msg]);
            }
            return redirect()->back()->with("error", "Payment service not available, try again later!!!");
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
        try{
            if ($response_status == true) {
                $response_data = $response['data'];               
                $txID = $response_data['reference'];    
                $transact = PaymentTransact::where("txref", $txID)->first();
                $request = json_decode($transact->customer);
                $transact->payment_status = "successful";
                $transact->service_status = 1;
                $transact->update();
                $amountCharge =  $transact->charged_amt ;
                $amount = $transact->vend_value;
                $phone = $request->phonenumber;
                $estate = $request->estate;
                $paid_month = $request->paid_month;
                $email = $request->email;
                $meternumber = $request->meternumber;
                 $charged = ChargesPayment::where('txref', $txID)->first();
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
                $paydate = ChargesPayment::where('meternumber', $meternumber)->orderBy('id', 'desc')->value('payment_date');
                if ($paydate) {
                    $lastpaydate = Carbon::parse($paydate)->addMonths($paid_month)->format("Y-m-d");
                }
                
                $charged = new ChargesPayment();
                $charged->estate_id = $estate;
                $charged->phonenumber = $phone;
                $charged->meternumber = $meternumber;
                $charged->txref = $txID;
                $charged->user_id = $transact->payerid;
                $charged->amount = $amount;
                $charged->email = $email;
                $charged->payment_date = $lastpaydate;
                $charged->no_of_month = $paid_month;
                $charged->save();
    
                $revenue = new Revenue();
                $revenue->txref = $txID;
                $revenue->payerid = $transact->payerid;
                $revenue->manager_user_id = $request->manager_id;
                $revenue->amount =   $amountCharge;
                $revenue->purchase_type = 2;
                $revenue->save();
                $notify = new Notification();
                $notify->user_id =$transact->payerid;
                $notify->type = 1;
                $notify->notify_msg =$paid_month. " month(s) service charge payment was successful.";
                $notify->save();
    
                $msg = "Payment successful";
                if ($transact->path == 0) {
                    $manageremail = Managers::where('user_id', $request->manager_id)->value('email');
                    $helper = new HelperClass();
                    $messageadmin = $email . " just pay " . $amount . " for his/her service charge for " . $paid_month . " month(s)";
                    $helper->sendEmail($manageremail, "Service charged payment notificaton", $messageadmin);
                    return redirect()->route('feedback', ['status' => 'ok', 'msg' => $msg]);
                }
                return redirect()->back()->with("success", $msg);
    
            } else {
    
                return redirect()->route('feedback', ['status' => 'error', 'msg' => $response_msg]);
    
            }
        } catch (\Throwable $th) {
                //throw $th;
                  return redirect()->route('feedback', ['status' => 'error', 'msg' => $response_msg]);
            
    
        }
    }

    public function PayServiceFee(Request $request)
    {
        $estateuser = estateuser::where('meternumber', $request->meternum)->first();
        $cPayment = ChargesPayment::where('meternumber', $request->meternum)->orderBy('id', 'desc')->first();
        $paid_month = $request->nummonth;
        $payamt = $request->paidamt;
        $reference = Paystack::genTranxRef();
        $charged = ChargesPayment::where('txref', $reference)->first();
        if($charged){
            return;
        }
        if ($cPayment) {
            $lastpaydate = Carbon::parse($request->expdate)->addMonths($paid_month)->format("Y-m-d");
            $charged = new ChargesPayment();
            $charged->estate_id = $estateuser->estate_id;
            $charged->phonenumber = $request->phone;
            $charged->meternumber = $request->meternum;
            $charged->txref = $reference;
            $charged->user_id = $estateuser->user_id;
            $charged->amount = $payamt;
            $charged->email = $request->email;
            $charged->payment_date = $lastpaydate;
            $charged->no_of_month = $paid_month;
            $charged->save();
        } else {
            $from = Carbon::now()->endOfMonth();      
            $to = Carbon::today();
            $diff_in_days = $to->diffInDays($from);
            $lastpaydate = Carbon::today()->endOfMonth()->addMonths($paid_month)->format("Y-m-d");
            if ($diff_in_days > 10) {
                $lastpaydate = Carbon::today()->startOfMonth()->addMonths($paid_month)->format("Y-m-d");
            }
            $charged = new ChargesPayment();
            $charged->estate_id = $estateuser->estate_id;
            $charged->phonenumber = $request->phone;
            $charged->meternumber = $request->meternum;
            $charged->txref = $reference;
            $charged->user_id = $estateuser->user_id;
            $charged->amount = $payamt;
            $charged->email = $request->email;
            $charged->payment_date = $lastpaydate;
            $charged->no_of_month = $paid_month;
            $charged->save();

        }

        $customer = [
            'email' => $request->email,
            "phonenumber" => $request->phone,
            'paid_month' => $paid_month,
            'estate' => $estateuser->estate_id,
            'meternumber' => $request->meternum,
        ];

        $transact = new PaymentTransact();
        $transact->payerid = $estateuser->user_id;
        $transact->path = 0;
        $transact->amount = $payamt;
        $transact->merchant = $estateuser->manager_user_id;
        $transact->charged_amt = 0.00;
        $transact->customer = json_encode($customer);
        $transact->txref = $reference;
        $transact->vend_value = $payamt;
        $transact->category = 1;
        $transact->channel = 1;
        $transact->service_status = 1;
        $transact->payment_status = "successful";
        $transact->save();
        return back()->with('success', 'Resident service fee updated');
    }

    public function LoadTransactions(Request $request)
    {
        $user = Auth::user();
        $from = $request->start_date;
        $to = $request->end_date;
        $transactions = array();
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        $meternumber = $user->estateuser->meternumber;
        if ($from == $today && $to == $today) {
            $transactions = ChargesPayment::where('meternumber', $meternumber)
                ->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();

        } else if ($from == $yesterday && $to == $yesterday) {
            $transactions = ChargesPayment::where('meternumber', $meternumber)
                ->whereDate('created_at', $yesterday)->orderBy('id', 'desc')->get();
        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $transactions = ChargesPayment::where('meternumber', $meternumber)
                ->whereBetween('created_at', $this_month)->orderBy('id', 'desc')->get();
        }
        foreach ($transactions as $key => $value) {
            # code...
            $value->transdate = \Carbon\Carbon::parse($value->updated_at)->format('d-m-Y H:m:s');
            $payday = $value->payment_date;
            $value->duedate = Carbon::parse($payday)->subDay()->format('d-m-Y');
        }
        return DataTables::of($transactions)
            ->make(true);

    }

    public function ServiceStat(Request $request)
    {
        $user=Auth::id();
        $thismonth = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->addDay()];
        $from = $request->start_date;
        $to = $request->end_date;
        $transactions = array();
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        $mNamef = Carbon::parse($from)->format('F');
        $mNamet = Carbon::parse($to)->format('F');
        if ($mNamef === $mNamet) {
            $mName = $mNamef;
        } else {
            $mName = $mNamef . " - " . $mNamet;
        }

        if ($from == $today && $to == $today) {
            $mPayment = ChargesPayment::whereDate('charges_payments.created_at', $today)
            ->join('estateusers', 'estateusers.user_id', 'charges_payments.user_id')->where('estateusers.manager_user_id', $user)
            ->sum('charges_payments.amount');
            $paidnum = ChargesPayment::whereDate('charges_payments.created_at', $today)
            ->join('estateusers', 'estateusers.user_id', 'charges_payments.user_id')->where('estateusers.manager_user_id', $user)
            ->count();

        } else if ($from == $yesterday && $to == $yesterday) {
            $mPayment = ChargesPayment::whereDate('charges_payments.created_at', $yesterday)
            ->join('estateusers', 'estateusers.user_id', 'charges_payments.user_id')->where('estateusers.manager_user_id', $user)
            ->sum('charges_payments.amount');
            $paidnum = ChargesPayment::whereDate('charges_payments.created_at', $yesterday)
              ->join('estateusers', 'estateusers.user_id', 'charges_payments.user_id')->where('estateusers.manager_user_id', $user)
            ->count();
        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $thismonth = [$start, $end];
            $mPayment = ChargesPayment::whereBetween('charges_payments.created_at', $thismonth)
             ->join('estateusers', 'estateusers.user_id', 'charges_payments.user_id')->where('estateusers.manager_user_id', $user)
            ->sum('charges_payments.amount');
            $paidnum = ChargesPayment::whereBetween('charges_payments.created_at', $thismonth)
              ->join('estateusers', 'estateusers.user_id', 'charges_payments.user_id')->where('estateusers.manager_user_id', $user)
            ->count();
        }

        return response()->json([
            "status" => "true",
            "mName" => $mName,
            "mPayment" => $mPayment,
            "paidnum" => $paidnum,
        ]);
    }

    public function ServiceTransactions(Request $request)
    {
        $user = Auth::user();
        $from = $request->start_date;
        $to = $request->end_date;
        $transactions = array();
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        if ($from == $today && $to == $today) {
            $transactions = ChargesPayment::whereDate('charges_payments.created_at', Carbon::today())
                ->join('users', 'users.id', 'charges_payments.user_id')
                ->join('estateusers', 'estateusers.user_id', 'charges_payments.user_id')
                ->where('estateusers.manager_user_id', $user->id)
                ->select('charges_payments.*', 'users.name', 'estateusers.housenum')->orderBy('id', 'desc')->get();

        } else if ($from == $yesterday && $to == $yesterday) {
            $transactions = ChargesPayment::whereDate('charges_payments.created_at', $yesterday)
                ->join('users', 'users.id', 'charges_payments.user_id')
                ->join('estateusers', 'estateusers.user_id', 'charges_payments.user_id')
                ->where('estateusers.manager_user_id', $user->id)
                ->select('charges_payments.*', 'users.name', 'estateusers.housenum')->orderBy('id', 'desc')->get();
        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $transactions = ChargesPayment::whereBetween('charges_payments.created_at', $this_month)
                ->join('users', 'users.id', 'charges_payments.user_id')
                ->join('estateusers', 'estateusers.user_id', 'charges_payments.user_id')
                ->where('estateusers.manager_user_id', $user->id)
                ->select('charges_payments.*', 'users.name', 'estateusers.housenum')->orderBy('id', 'desc')->get();
        }
        foreach ($transactions as $key => $value) {
            # code...
            $value->transdate = \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:m:s');
            $payday = $value->payment_date;
            $value->duedate = Carbon::parse($payday)->subDay()->format('d-m-Y');
        }
       return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                &nbsp; &nbsp;
                <a class="edit" style="cursor: pointer;" data-toggle="modal" data-target="#modal-update-date" data-id="' . $row->id . '"
                data-placement="top" title="Edit" ><i class="fa fa-edit text-success" style="cursor: pointer;"></i> Update</a>
                &nbsp; &nbsp;';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
 
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChargesPayment  $chargesPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ChargesPayment $chargesPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChargesPayment  $chargesPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $charged = ChargesPayment::where('id', $request->id)->first();
        $charged->payment_date = Carbon::parse($request->paymentdate)->format('Y-m-d');
        $charged->update();
        return response()->json([
            "status" => "ok",
            "msg" => " Renewal date updated",
        ]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChargesPayment  $chargesPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChargesPayment $chargesPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChargesPayment  $chargesPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChargesPayment $chargesPayment)
    {
        //
    }
}