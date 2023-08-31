<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SpaceLets;
use Auth;
use DataTables;
use Illuminate\Http\Request;

class BookingController extends Controller
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
            $cbooking = Booking::where("bookings.status", 0)->join('space_lets', 'space_lets.id', 'bookings.space_id')
                ->where('space_lets.manager_user_id', $user->id)->count();
            $booking = Booking::join('space_lets', 'space_lets.id', 'bookings.space_id')
                ->where('space_lets.manager_user_id', $user->id)
                ->join('users', 'users.id', 'bookings.user_id')
                ->join('estateusers', 'users.id', 'estateusers.user_id')
                ->select('users.name', "users.email", "estateusers.phonenumber", "bookings.booking_date", 'bookings.id',
                    "bookings.status as status", 'space_lets.name as venue', "space_lets.cost")->get();
            if (request()->ajax()) {
                return DataTables::of($booking)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '
                         <a class="show" data-id="' . $row->id . '" data-placement="top" title="edit" style="cursor: pointer; ><i class="fa fa-eye text-success"> View</i></a>
                         &nbsp; &nbsp;
                         ';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('manager.booking', compact('cbooking'));

        } else if ($user->role == 4) {
            $booking = Booking::where("user_id", $user->id)->join('space_lets', 'space_lets.id', 'bookings.space_id')
                ->select("bookings.description", "bookings.booking_date",
                    "bookings.status as status", 'space_lets.name as venue', "space_lets.cost", 'bookings.id')->get();
                  
            $manager_user_id = Auth::user()->estateuser->manager_user_id;
            $spaces = SpaceLets::where("manager_user_id", $manager_user_id)
                ->select('name', 'cost', 'id')->get();
            if (request()->ajax()) {
                return DataTables::of($booking)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '
                         <a class="edit edit-msg" data-id="' . $row->id . '" data-placement="top" title="edit" style="cursor: pointer; ><i class="fa fa-edit text-success"> Edit</i></a>
                         &nbsp; &nbsp;
                         <a class="delete" data-id="' . $row->id . '" data-placement="top" title="delete" style="cursor: pointer; ><i class="fa fa-trash text-danger"> Delete</i></a>
                         &nbsp; &nbsp;
                         ';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            $bookcnt = count($booking);
            return view('resident.booking', compact('spaces', 'bookcnt'));
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
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->space_id = $request->venue;
        $booking->booking_date = $request->bookdate;
        $booking->description = $request->description;
        $booking->save();
        return response()->json([
            "status" => "ok",
            "Message" => "Space booked successfully",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $booking = Booking::where('bookings.id', $id)
            ->join('space_lets', 'space_lets.id', 'bookings.space_id')
            ->join('users', 'users.id', 'bookings.user_id')
            ->join('estateusers', 'users.id', 'estateusers.user_id')
            ->select('users.name', "users.email", "estateusers.phonenumber",
            'bookings.id', "bookings.space_id", "bookings.description","bookings.booking_date","space_lets.name as venue",
                "bookings.status as status", "space_lets.cost")->first();
        return response()->json($booking);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $booking = Booking::where('id', $id)->first();
        $booking->space_id = $request->venue;
        $booking->booking_date = $request->bookdate;
        $booking->update();
        return response()->json([
            "status" => "ok",
            "Message" => "Booking details update successfully",
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        Booking::where('id', $id)->first()->delete();
        return response()->json([
            "status" => "ok",
            "msg" => "Booking details delete successfully",
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}