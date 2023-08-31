<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use App\Models\Setting;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallet = Setting::where('manager_user_id', Auth::id())->value('wallet_balance');
        $tincome = Revenue::sum('amount');
        $thismonth = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->addDay()];
        $tmonth = Revenue::whereBetween('created_at', $thismonth)->sum('amount');
        $thisweek = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()->addDay()];
        $tweek = Revenue::whereBetween('created_at', $thisweek)->sum('amount');
        return view('admin.revenue_manager', compact('wallet', 'tincome', 'tmonth', 'tweek'));
    }

    public function RevenueStat(Request $request)
    {
        $from = $request->start_date;
        $to = $request->end_date;
        $rquery = 0;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        $thismonth = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->addDay()];

        if (($from == $today && $to == $today) || ($from == $yesterday && $to == $yesterday)) {
            $rquery = Revenue::whereDate('created_at', $from)->sum('amount');

        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $rquery = Revenue::whereBetween('created_at', $this_month)
                ->sum('amount');
        }
        return response()->json([
            "rquery" => $rquery,
        ]);
    }

    public function RevenueDetails(Request $request)
    {

        $from = $request->start_date;
        $to = $request->end_date;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        if (($from == $today && $to == $today) || ($from == $yesterday && $to == $yesterday)) {
            $transactions = Revenue::whereDate('revenues.created_at', $from)
                ->join('estateusers', 'estateusers.user_id', 'revenues.payerid')
                ->join('estates', 'estates.id', 'estateusers.estate_id')
                ->join('users', 'users.id', 'estateusers.user_id')
                ->select('revenues.*', 'users.name as payer','estates.name as estate')
                ->orderBy('id', 'desc')->get();

        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $transactions = Revenue::whereBetween('revenues.created_at', $this_month)
            ->join('estateusers', 'estateusers.user_id', 'revenues.payerid')
            ->join('estates', 'estates.id', 'estateusers.estate_id')
            ->join('users', 'users.id', 'estateusers.user_id')
            ->select('revenues.*', 'users.name as payer','estates.name as estate')
            ->orderBy('id', 'desc')->get();
         

        }
        foreach ($transactions as $key => $value) {
            # code...
            $value->transdate = \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:m:s');
        }

        return DataTables::of($transactions)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function show(Revenue $revenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Revenue $revenue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Revenue $revenue)
    {
        //
    }
}