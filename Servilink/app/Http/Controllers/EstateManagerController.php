<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\estateuser;
use App\Models\PaymentTransact;
use App\Models\User;
use App\Models\VendingTransaction;
use Auth;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;

class EstateManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estates = Estate::where('manager_user_id', Auth::id())->count();
        return view('manager.manager_estate', compact('estates'));
    }

    public function loadDashstat()
    {
        $user = Auth::user();
        $totalmanageruser = estateuser::where('manager_id', $user->id)->count();
        $tpurchase = VendingTransaction::where('merchant_id', $user->merchant_id)->where('vending_transactions.verified', 1)->sum('vend_value');
        $tservice = PaymentTransact::where('merchant', $user->name)->where('payment_status', 'successful')->where('category', 2)->sum('amount');

        return response()->json([
            "status" => "true",
            "tresident" => $totalmanageruser,
            "tpurchase" => $tpurchase,
            "tservice" => $tservice,
        ]);
    }

 

    public function LoadEstate()
    {

        $user = Auth::user();
        $estate = Estate::where('manager_user_id', $user->id)->get();

        foreach ($estate as $key => $value) {

            $value->resident = estateuser::where('estate_id', $value->id)->count();

        }
        return DataTables::of($estate)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                &nbsp; &nbsp;
                <a class="delete" data-id="' . $row->id . '"
                 title="delete" ><i class="fa fa-trash text-danger"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
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
        $estate = new Estate();
        $estate->name = $request->name;
        $estate->address = $request->address;
        $estate->service_charge = $request->service_charge;
        $estate->manager_user_id = Auth::id();
        $estate->save();
        return response()->json([
            "status" => "ok",
            "msg" => "Estate Added",
        ]);
    }

    public function deleteEstate(Request $request)
    {
        $id = $request->id;
        Estate::where('id', $id)->first()->delete();

        return response()->json([
            "status" => "ok",
            "msg" => "Estate deleted",
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id9
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
    public function edit($id)
    {
        //
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