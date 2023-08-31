<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\estateuser;
use Auth;

use App\Models\Managers;
use App\Models\Setting;
use Illuminate\Http\Request;
use DataTables;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estates = Estate::get();
        foreach ($estates as $key => $value) {
            # code...
            $value->manager = Managers::where('user_id',$value->manager_user_id)->value('name');
            $value->resident = estateuser:: where('estate_id',$value->id)->count();
        }
       
        $wallet = Setting::where('manager_user_id', Auth::id())->value('wallet_balance');
        if (request()->ajax()) {
            return DataTables::of($estates)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                     <a class="edit edit-msg" data-id="' . $row->id . '" data-placement="top" title="edit" ><i class="fa fa-edit text-success"> Edit</i></a>
                     &nbsp; &nbsp;
                     <a class="delete" data-id="' . $row->id . '" data-placement="top" title="delete" ><i class="fa fa-trash text-danger"> Delete</i></a>
                     &nbsp; &nbsp;
                     ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.estates', compact('estates','wallet'));
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
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $estate= Estate::where('id', $request->id)->first();
        return response()->json($estate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $estate= Estate::where('id', $request->id)->first();
        $estate->address = $request->address;
        $estate->name = $request->name;
        $estate->service_charge = $request->service_charge;
        $estate->update();
        return response()->json([
            "status" => "ok",
            "Message" => "Estate details update successfully",
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estate $estate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estate $estate)
    {
        //
    }
}