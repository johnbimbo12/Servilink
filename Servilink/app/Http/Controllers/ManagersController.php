<?php

namespace App\Http\Controllers;

use App\Helpers\HelperClass;
use App\Models\Estate;
use App\Models\Managers;
use App\Models\Revenue;
use App\Models\ServiceAccount;
use App\Models\Setting;
use App\Models\User;
use App\Models\VendingTransaction;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $managers = Managers::get();
        foreach ($managers as $key => $value) {
            # code...
            $value->estate = Estate::where('manager_user_id', $value->user_id)->count();
            $value->income = Revenue::where('manager_user_id', $value->user_id)->sum('amount');
            $value->sales = VendingTransaction::where('merchant_id', $value->user_id)->sum('vend_value');
        }

        $wallet = Setting::where('manager_user_id', Auth::id())->value('wallet_balance');
        if (request()->ajax()) {
            return DataTables::of($managers)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                     <a class="edit edit-msg" data-id="' . $row->user_id . '" data-placement="top" title="edit" ><i class="fa fa-edit text-success"> Edit</i></a>
                     &nbsp; &nbsp;
                     <a class="delete" data-id="' . $row->user_id . '" data-placement="top" title="delete" ><i class="fa fa-trash text-danger"> Delete</i></a>
                     &nbsp; &nbsp;
                     ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.estate_manager', compact('managers', 'wallet'));
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

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                "status" => "info",
                "Message" => "Manager exist",
            ]);
        }
        try{

            $user = new User();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->role = 2;
            $user->password = Hash::make($request->phone);
            $user->save();
            $manager_user_id =  $user->id;
            $manager = new Managers();
            $manager->name = $request->name;
            $manager->user_id = $manager_user_id;
            $manager->email = $request->email;
            $manager->phonenumber = $request->phone;
            $manager->status = 1;
            $manager->save();
            $setting = new Setting();
            $setting->transaction_fee = 600;
            $setting->manager_user_id =   $manager_user_id;
            $setting->service_trans_fee = 100;
            $setting->on_credit_fee = 10;
            $setting->min_vend = 20000;
            $setting->save();
          
    
            if (!empty($request->power) && !empty($request->powerbank) && !empty($request->powernuban)) {
                $power = new ServiceAccount();
                $power->subaccount_id = $request->power;
                $power->bank = $request->powerbank;
                $power->account_number = $request->powernuban;
                $power->manager_user_id = $manager_user_id;
                $power->service_type = 0;
                $power->save();
            }
    
            if (!empty($request->service) && !empty($request->servicebank) && !empty($request->servicenuban)) {
                $service = new ServiceAccount();
                $service->subaccount_id = $request->service;
                $service->bank = $request->servicebank;
                $service->account_number = $request->servicenuban;
                $service->manager_user_id = $manager_user_id;
                $service->service_type = 1;
                $service->save();
            }
    
            if (!empty($request->water) && !empty($request->waterbank) && !empty($request->waternuban)) {
                $water = new ServiceAccount();
                $water->subaccount_id = $request->water;
                $water->bank = $request->waterbank;
                $water->account_number = $request->waternuban;
                $water->manager_user_id = $manager_user_id;
                $water->service_type = 2;
                $water->save();
            }
    
            $helper = new HelperClass();
            $helper->sendRegistrationEmail($request->email, "Account Creation", $user);
            return response()->json([
                "status" => "ok",
                "Message" => "Manager account create successfully",
            ]);
      
        } catch (\Throwable $th) {
            //throw $th;
              return response()->json([
                "status" => "fail",
                "Message" => "Manager account create fail",
            ]);
        }

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Managers  $managers
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $manager = Managers::where('user_id', $request->id)->first();
        $setting = Setting::where('manager_user_id', $request->id)->first();
        $accounts = ServiceAccount::where('manager_user_id', $request->id)->get();

        $account = array();
        foreach ($accounts as $key => $value) {
            if ($value->service_type == 0) {
                $account['power'] = $value->subaccount_id;
                $account['powerbank'] = $value->bank;
                $account['powernuban'] = $value->account_number;
            } else if ($value->service_type == 1) {
                $account['service'] = $value->subaccount_id;
                $account['servicebank'] = $value->bank;
                $account['servicenuban'] = $value->account_number;
            } else if ($value->service_type == 2) {
                $account['water'] = $value->subaccount_id;
                $account['waterbank'] = $value->bank;
                $account['waternuban'] = $value->account_number;
            }
        }

        return response()->json(["manager" => $manager, "setting" => $setting, 'account' => $account]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Managers  $managers
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        \Log::info($request);
        if ((int)$request->tab == 1) {
            $user = User::where('id', $request->user_id)->first();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->update();
            $manager = Managers::where('user_id', $request->user_id)->first();
            $manager->name = $request->name;
            $manager->email = $request->email;
            $manager->phonenumber = $request->phone;
            $manager->status = $request->status;
            $manager->update();
        } elseif ((int)$request->tab == 2) {

            $setting = Setting::where('manager_user_id', $request->user_id)->first();
            $setting->transaction_fee = $request->vendfee;
            $setting->service_trans_fee = $request->servicecharge;
            $setting->on_credit_fee = $request->creditfee;
            $setting->min_vend = $request->minvend;
            $setting->update();

        } elseif ((int)$request->tab == 3) {
            $power = ServiceAccount::where('manager_user_id', $request->user_id)->where('service_type', 0)->first();
            if ($power) {
                $power->subaccount_id = $request->power;
                $power->bank = $request->powerbankname;
                $power->account_number = $request->powernuban;
                $power->update();
            } else {
                $power = new ServiceAccount();
                $power->subaccount_id = $request->power;
                $power->bank = $request->powerbankname;
                $power->account_number = $request->powernuban;
                $power->manager_user_id = $request->user_id;
                $power->service_type = 0;
                $power->save();
            }

            $service = ServiceAccount::where('manager_user_id', $request->user_id)->where('service_type', 1)->first();
            if ($service) {
                $service->subaccount_id = $request->service;
                $service->bank = $request->servicebankname;
                $service->account_number = $request->servicenuban;
                $service->update();
            } else {
                $service = new ServiceAccount();
                $service->subaccount_id = $request->service;
                $service->bank = $request->servicebankname;
                $service->account_number = $request->servicenuban;
                $service->manager_user_id = $request->user_id;
                $service->service_type = 1;
                $service->save();
            }

            $water = ServiceAccount::where('manager_user_id', $request->user_id)->where('service_type', 2)->first();
            if ($water) {
                $water->subaccount_id = $request->water;
                $water->bank = $request->waterbankname;
                $water->account_number = $request->waternuban;
                $water->update();
            } else {
                $water = new ServiceAccount();
                $water->subaccount_id = $request->water;
                $water->bank = $request->waterbankname;
                $water->account_number = $request->waternuban;
                $water->manager_user_id = $request->user_id;
                $water->service_type = 2;
                $water->save();
            }

        }
        return response()->json([
            "status" => "ok",
            "Message" => "Manager's account update successfully",
        ]);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Managers  $managers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Managers $managers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Managers  $managers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Managers $managers)
    {
        //
    }

    public function deleteAccount(Request $request)
    {
        $id = $request->id;
        User::where('id', $id)->first()->delete();
        Managers::where('user_id', $id)->first()->delete();
        Setting::where('manager_user_id', $id)->first()->delete();
        return response()->json([
            "status" => "ok",
            "msg" => "Manager deleted",
        ]);

    }
}