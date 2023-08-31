<?php

namespace App\Http\Controllers;

use App\Models\Managers;
use App\Models\ServiceAccount;
use App\Models\Setting;
use Auth;
use Illuminate\Http\Request;

class SettingController extends Controller
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
            $settings = Managers::where('user_id', $user->id)->select('name', 'email', 'phonenumber')->first();
            $accounts = ServiceAccount::where('service_accounts.manager_user_id', $user->id)->get();
            foreach ($accounts as $key => $value) {
                # code...
                if ($value->service_type == 0) {
                    $settings->pbank = $value->bank;
                    $settings->pnuban = $value->account_number;

                } else if ($value->service_type == 1) {
                    $settings->sbank = $value->bank;
                    $settings->snuban = $value->account_number;
                } else if ($value->service_type == 2) {
                    $settings->wbank = $value->bank;
                    $settings->wnuban = $value->account_number;
                }
            }

            return view('manager.global_setting', compact('settings'));
        } else if ($user->role == 1) {
            $wallet = Setting::where('manager_user_id', $user->id)->value('wallet_balance');
            return view('admin.globals_setting', compact('user', 'wallet'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function BankDetails(Request $request)
    {

        try {
            $user_id = Auth::id();
            $power = ServiceAccount::where('manager_user_id', $user_id)->where('service_type', 0)->first();
            if ($power) {
                $power->account_number = $request->power;
                $power->bank = $request->powerbankname;
                $power->update();
            } else {
                $power = new ServiceAccount();
                $power->account_number = $request->power;
                $power->bank = $request->powerbankname;
                $power->manager_user_id = $user_id;
                $power->service_type = 0;
                $power->save();
            }

            $service = ServiceAccount::where('manager_user_id', $user_id)->where('service_type', 1)->first();
            if ($service) {
                $service->account_number = $request->service;
                $service->bank = $request->servicebankname;
                $service->update();
            } else {
                $service = new ServiceAccount();
                $service->account_number = $request->service;
                $service->bank = $request->servicebankname;
                $service->manager_user_id = $user_id;
                $service->service_type = 1;
                $service->save();
            }

            $water = ServiceAccount::where('manager_user_id', $user_id)->where('service_type', 2)->first();
            if ($water) {
                $water->account_number = $request->water;
                $water->bank = $request->waterbankname;
                $water->update();
            } else {
                $water = new ServiceAccount();
                $water->account_number = $request->water;
                $water->bank = $request->waterbankname;
                $water->manager_user_id = $user_id;
                $water->service_type = 2;
                $water->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with("error", "Update fails, Try again");
        }

        return redirect()->back()->with("success", "Update successfully");

    }

    public function UpdateAccount(Request $request)
    {

        try {
            //code...
            $user = Auth::user();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->update();
            $manager = Managers::where('user_id', $user->id)->first();
            $manager->name = $request->name;
            $manager->email = $request->email;
            $manager->phonenumber = $request->phonenumber;
            $manager->update();
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with("error", "Update fails, Try again");
        }

        return redirect()->back()->with("success", "Update successfully");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}