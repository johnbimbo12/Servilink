<?php

namespace App\Http\Controllers;

use App\Models\WaterManager;
use Auth;


use App\Helpers\HelperClass;
use App\Models\ChargesPayment;
use App\Models\CreditPurchase;
use App\Models\estateuser;
use App\Models\PaymentTransact;
use App\Models\PowerManager;
use App\Models\Revenue;
use App\Models\ServiceAccount;
use App\Models\Setting;
use App\Models\User;
use App\Models\VendingTransaction;

use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class WaterManagerController extends Controller
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
            return view('manager.water_manager');
        } else if ($user->role == 4) {
            return view('resident.water_manager', compact('user'));
        }
        else if($user->role==1){
            $wallet = Setting::where('manager_user_id', $user->id)->value('wallet_balance');
            $credit = CreditPurchase::where('service_type', 0)->where('pay_status', 0)->sum('amt_to_pay');
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $this_month = [$start, $end];
            $meter = estateuser::where('estateusers.manager_user_id', $user->id)->count();
            $prevenue = Revenue::whereBetween('created_at', $this_month)->sum('amount');
            $monthsale = VendingTransaction::where('verified', 1)->whereBetween('created_at', $this_month)->sum('amount');

            return view('admin.water_manager', compact('user', 'wallet', 'credit', 'monthsale', 'prevenue', 'meter'));
        }
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
     * @param  \App\Models\WaterManager  $waterManager
     * @return \Illuminate\Http\Response
     */
    public function show(WaterManager $waterManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WaterManager  $waterManager
     * @return \Illuminate\Http\Response
     */
    public function edit(WaterManager $waterManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WaterManager  $waterManager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WaterManager $waterManager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WaterManager  $waterManager
     * @return \Illuminate\Http\Response
     */
    public function destroy(WaterManager $waterManager)
    {
        //
    }
}