<?php

namespace App\Http\Controllers;

use App\Models\estateuser;
use App\Models\PaymentTransact;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class PaymentTransactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Transactions()
    {
        $user = Auth::user();
        if ($user->role == 2) {
            return view('manager.transactions_history');
        } else if ($user->role == 4) {
            $fail = PaymentTransact::where('payerid', $user->id)->where('service_status', '==', 0)->count();
            $success = PaymentTransact::where('payerid', $user->id)->where('service_status', 1)->count();
            return view('resident.transactions_history', compact('fail', 'success'));
        }
    }

    public function LoadTransactions(Request $request)
    {
        $user = Auth::user();
        $from = $request->start_date;
        $to = $request->end_date;
        $transactions = array();
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        if ($from == $today && $to == $today) {
            $transactions = PaymentTransact::where('payerid', $user->id)
                ->where('payment_status', 'successful')
                ->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();

        } else if ($from == $yesterday && $to == $yesterday) {
            $transactions = PaymentTransact::where('payerid', $user->id)
                ->where('payment_status', 'successful')
                ->whereDate('created_at', $yesterday)->orderBy('id', 'desc')->get();
        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $transactions = PaymentTransact::where('payerid', $user->id)
               ->where('payment_status', 'successful')
                ->whereBetween('created_at', $this_month)->orderBy('id', 'desc')->get();
        }
        foreach ($transactions as $key => $value) {
            # code...
            $value->transdate = \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:m:s');
        }


        if (request()->ajax()) {
            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <a href="' . "/vending/verify/" . $row->txref . ' "  data-id="' . $row->id . '" data-placement="top">Request Token</a>
                    &nbsp; &nbsp;
                     ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function RevenueTransactions(Request $request)
    {
        $user = Auth::user();
        $from = $request->start_date;
        $to = $request->end_date;
        $transactions = array();
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");

        if ($from == $today && $to == $today) {
            $transactions = PaymentTransact::where('payment_transacts.merchant', $user->id)
            ->where('payment_transacts.payment_status', "successful")
            ->whereDate('payment_transacts.created_at', Carbon::today())
                ->join('users', 'users.id', 'payment_transacts.payerid')
               ->orderBy('id', 'desc')
                ->select('payment_transacts.*', 'users.name')->get();

        } else if ($from == $yesterday && $to == $yesterday) {
            $transactions = PaymentTransact::where('payment_transacts.merchant', $user->id)
            ->where('payment_transacts.payment_status', "successful")
            ->whereDate('payment_transacts.created_at', $yesterday)
                ->join('users', 'users.id', 'payment_transacts.payerid')
               ->orderBy('id', 'desc')
                ->select('payment_transacts.*', 'users.name')->get();
        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $transactions = PaymentTransact::where('payment_transacts.merchant', $user->id)
            ->where('payment_transacts.payment_status', "successful")
            ->whereBetween('payment_transacts.created_at', $this_month)
                ->join('users', 'users.id', 'payment_transacts.payerid')
               ->orderBy('id', 'desc')
                ->select('payment_transacts.*', 'users.name')->get();
        }
        foreach ($transactions as $key => $value) {

            $value->transdate = \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:m:s');
        }

        if (request()->ajax()) {
            return DataTables::of($transactions)
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function RevenueStat( Request $request)
    {
        $user = Auth::user();
        $from = $request->start_date;
        $to = $request->end_date;
        $rquery =0;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        $thismonth = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->addDay()];
        $monthamt =PaymentTransact::where('payment_transacts.merchant', $user->id)
            ->where('payment_transacts.payment_status', "successful")
        ->whereBetween('payment_transacts.created_at', $thismonth)->sum('vend_value');
        $trevenue =PaymentTransact::where('payment_transacts.merchant', $user->id)
            ->where('payment_transacts.payment_status', "successful")->sum('vend_value');
        if ($from == $today && $to == $today) {
            $rquery = PaymentTransact::where('payment_transacts.merchant', $user->id)
            ->where('payment_transacts.payment_status', "successful")
            ->whereDate('created_at', $today)->value('vend_value');
        } else if ($from == $yesterday && $to == $yesterday) {
            $rquery = PaymentTransact::where('payment_transacts.merchant', $user->id)
            ->where('payment_transacts.payment_status', "successful")
            ->whereDate('created_at', $yesterday)->value('vend_value');
        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $rquery =  PaymentTransact::where('payment_transacts.merchant', $user->id)
            ->where('payment_transacts.payment_status', "successful")
            ->whereBetween('created_at',$this_month)
           ->sum('vend_value');
        }
        return response()->json([
            "status" => "true",
            "trevenue" => $trevenue,
            "tmonth" => $monthamt,
            "rquery" => $rquery
        ]);
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
     * @param  \App\Models\PaymentTransact  $paymentTransact
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentTransact $paymentTransact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentTransact  $paymentTransact
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentTransact $paymentTransact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentTransact  $paymentTransact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentTransact $paymentTransact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentTransact  $paymentTransact
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentTransact $paymentTransact)
    {
        //
    }
}