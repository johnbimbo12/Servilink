<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\Notification;
use App\Models\Security;
use App\Models\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estates = Estate::where('manager_user_id', Auth::id())->get();
        $cnt = Security::where("manager_user_id", Auth::id())->count();
        return view('manager.security', compact('cnt', 'estates'));
    }

    public function LoadSecurity()
    {
        $security = Security::where("securities.manager_user_id", Auth::id())
            ->join('estates', 'securities.estate_id', 'estates.id')
            ->join('users', 'securities.user_id', 'users.id')
            ->select('securities.id','users.name as name', 'users.email', 'securities.phonenumber', 'securities.status', 'estates.name as estate')->get();
        return DataTables::of($security)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                         <a class="edit" data-id="' . $row->id . '" data-placement="top" title="edit" style="cursor: pointer;" ><i class="fa fa-edit text-success"> Edit</i></a>
                         &nbsp; &nbsp;
                         <a class="delete" data-id="' . $row->id . '" data-placement="top" title="delete" style="cursor: pointer;" ><i class="fa fa-trash text-danger"> Delete</i></a>
                         &nbsp; &nbsp;
                         ';
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
        
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                "status" => "info",
                "Message" => "Email already exist",
            ]);
        }
        try {

            $user = new User();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->role = 5;
            $user->password = Hash::make($request->password);
            $user->save();
            $security = new Security();
            $security->estate_id = $request->estate;
            $security->user_id = $user->id;
            if($request->status == "on"){
                $security->status =1;
            }else{
                $security->status =0;   
            }
            $security->manager_user_id = Auth::id();
            $security->phonenumber = $request->phone;
            $security->save();

            $estate = Estate::where('id', $request->estate)->first();
            $notify = new Notification();
            $notify->user_id = Auth::id();
            $notify->type = 3;
            $notify->notify_msg = "Security account created for " . $estate->name . "Estate. Login Details , Email: " . $request->email . " Password: " . $request->password;
            $notify->save();

            return response()->json([
                "status" => "ok",
                "Message" => "Security account create successfully",
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            \Log::info($th);
            return response()->json([
                "status" => "fail",
                "Message" => "Security account create fail",
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Security  $security
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $security = Security::where("securities.id", $id)
            ->join('estates', 'securities.manager_user_id', 'estates.manager_user_id')
            ->join('users', 'securities.user_id', 'users.id')
            ->select('securities.id', 'users.name', 'users.email', 'securities.phonenumber', 'securities.status', 'estates.id as estate_id')->first();
        return response()->json($security);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Security  $security
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
        $security = Security::where("id", $request->id)->first();
        $user = User::where('id', $security->user_id)->first();
        $user->email = $request->email;
        $user->name = $request->name;
        if(!empty($request->password)){
             $user->password = Hash::make($request->password);
        }
       
        $user->update();
          if($request->status == "on"){
                $security->status =1;
            }else{
                $security->status =0;   
            }
        $security->phonenumber = $request->phone;
        $security->update();
        return response()->json([
            "status" => "ok",
            "Message" => "Security's account update successfully",
        ]);

    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $security = Security::where("id", $id)->first();
        User::where('id', $security->user_id)->first()->delete();
        $security->delete();
        return response()->json([
            "status" => "ok",
            "msg" => "Security account deleted",
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Security  $security
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Security $security)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Security  $security
     * @return \Illuminate\Http\Response
     */
    public function destroy(Security $security)
    {
        //
    }
}