<?php

namespace App\Http\Controllers;

use App\Models\Emergency;
use App\Models\EmergencyContacts;
use Auth;
use DataTables;
use Illuminate\Http\Request;

class EmergencyController extends Controller
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
            $contact = "";
            $emergency = Emergency::join('users', 'users.id', 'emergencies.user_id')
                ->join('estateusers', 'users.id', 'estateusers.user_id')
                ->join('estates', 'estates.id', 'estateusers.estate_id')
                ->select('users.name', "users.email", "estateusers.phonenumber", "estates.name as estate",
                    "emergencies.status as status", 'estateusers.housenum', 'emergencies.alert_time', 'emergencies.user_id')->get();
            foreach ($emergency as $key => $value) {
                # code...
                $contacts = EmergencyContacts::where('user_id', $value->user_id)->get();
                foreach ($contacts as $key => $value) {
                    # code...
                    $contact = $contact . ", " . $value->contact_phone;
                }
                $emergency->contacts = $contact;

            }
            if (request()->ajax()) {
                return DataTables::of($emergency)
                    ->make(true);
            }

            return view('manager.emergency');

        } else if ($user->role == 4) {
            $contacts = EmergencyContacts::where("user_id", $user->id)->get();
            if (request()->ajax()) {
                return DataTables::of($contacts)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '
                         <a class="edit edit-msg" data-id="' . $row->id . '" data-placement="top" title="edit"  style="cursor: pointer;" ><i class="fa fa-edit text-success"> Edit</i></a>
                         &nbsp; &nbsp;
                             <a class="delete" data-id="' . $row->id . '" data-placement="top" title="delete"  style="cursor: pointer;" ><i class="fa fa-trash text-danger"> Delete</i></a>
                         &nbsp; &nbsp;
                         ';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('resident.emergency');
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
     * @param  \App\Models\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function show(Emergency $emergency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function edit(Emergency $emergency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emergency $emergency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Emergency $emergency)
    {
        //
    }
}