<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContacts;
use Illuminate\Http\Request;
use Auth;
class EmergencyContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function store(Request $request)
    {
        $user = Auth::user();
        $currentcontacts = EmergencyContacts::where('user_id', $user->id)->get();
        if (count($currentcontacts) == 5) {
            $alert = "Maximum number of contacts reached";
            return response()->json([
                "status" => "ok",
                "Message" => $alert,
            ]);
        }
        $emergencycontact = EmergencyContacts::where('contact_phone', $request->contact_phone)->orWhere('contact_name', $request->contact_name)->first();
        if ($emergencycontact) {
            $alert = "Contact already added";
            return response()->json([
                "status" => "ok",
                "Message" => "Contact already added",
            ]);
        }
        $emergencycontact = new EmergencyContacts();
        $emergencycontact->user_id = $user->id;
        $emergencycontact->contact_phone = $request->contact_phone;
        $emergencycontact->contact_name = $request->contact_name;
        $emergencycontact->save();
        return response()->json([
            "status" => "ok",
            "Message" => "Contact booked successfully",
        ]);

    }
    public function deleteContact(Request $request)
    {
            $emergencycontact = EmergencyContacts::where('id', $request->id)->first();
            if ($emergencycontact) {
                $emergencycontact->delete();
            }
            return response()->json([
                "status" => "ok",
                "Message" => "Contacts details deleted successfully",
            ]);

    }

    public function show(Request $request)
    {
        $id = $request->id;
        $emergencycontact = EmergencyContacts::where('id',$id)->first();
        return response()->json($emergencycontact);
    }

   
    public function edit(Request $request)
    {
        $id= $request->id;
        $emergencycontact = EmergencyContacts::where('id', $id)->first();
        $emergencycontact->contact_phone = $request->contact_phone;
        $emergencycontact->contact_name = $request->contact_name;
        $emergencycontact->update();
        return response()->json([
            "status" => "ok",
            "Message" => "Contact details update successfully",
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmergencyContacts  $emergencyContacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmergencyContacts $emergencyContacts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmergencyContacts  $emergencyContacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmergencyContacts $emergencyContacts)
    {
        //
    }
}