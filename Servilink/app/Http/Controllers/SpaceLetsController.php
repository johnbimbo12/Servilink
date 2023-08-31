<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Estate;
use App\Models\SpaceLets;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DataTables;
use Illuminate\Http\Request;

class SpaceLetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $space = SpaceLets::where("manager_user_id", Auth::id())->get();
        $estates = Estate::where('manager_user_id', Auth::id())->get();
        $tspace = SpaceLets::where("manager_user_id", Auth::id())->sum('total_allocation');
        $booked = SpaceLets::where("manager_user_id", Auth::id())->sum('used_allocation');
        if (request()->ajax()) {
            return DataTables::of($space)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                     <a class="edit edit-msg" data-id="' . $row->id . '" data-placement="top" title="edit" style="cursor: pointer;" ><i class="fa fa-edit text-success"> Edit</i></a>
                     &nbsp; &nbsp;
                     <a class="delete" data-id="' . $row->id . '" data-placement="top" title="delete" style="cursor: pointer;" ><i class="fa fa-trash text-danger"> Delete</i></a>
                     &nbsp; &nbsp;
                     ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('manager.space', compact('tspace', 'booked', 'estates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadspace()
    {
        $user = Auth::user();
        $manager_user_id = $user->estateuser->manager_user_id;
        $space = SpaceLets::where('manager_user_id', $manager_user_id)->select('name', 'cost', 'id')->get();
        return response()->json($space);
    }

    public function availablespace(Request $request)
    {
        $user = Auth::user();
        $manager_user_id = $user->estateuser->manager_user_id;
        $availableSpace = [];
        $date = $request->date;
        $start = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        $end = Carbon::parse($date)->endOfMonth()->format('Y-m-d');
        $this_month = [$start, $end];
        $bookings = Booking::where('space_id', $request->id)->whereBetween('booking_date', $this_month)->select('booking_date')
            ->get();

        $period = CarbonPeriod::create($start, $end);
        foreach ($period as $date) {
            $chkdate = $date->format('Y-m-d');
            if (count($bookings) == 0) {
                array_push($availableSpace, $chkdate);
            } else {
                if (in_array($chkdate, $bookings)) {
                } else {
                    array_push($availableSpace, $chkdate);
                }
            }

        }
        return response()->json($availableSpace);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $space = SpaceLets::where('name', $request->name)->first();
        if ($space) {
            return response()->json([
                "status" => "info",
                "Message" => "Space exist",
            ]);
        }
        try {
            $space = new SpaceLets();
            $space->estate_id = $request->estate;
            $space->name = $request->name;
            $space->manager_user_id = Auth::id();
            $space->cost = $request->amount;
            $space->save();
            return response()->json([
                "status" => "ok",
                "Message" => "New space added successfully",
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => "fail",
                "Message" => "Space create fail",
            ]);
        }

    }

    public function show(Request $request)
    {
        $id = $request->id;
        $space = SpaceLets::where('id', $id)->first();
        return response()->json($space);
    }

    public function edit(Request $request)
    {
        $space = SpaceLets::where('id', $request->id)->first();
        $space->name = $request->name;
        $space->cost = $request->amount;
        $space->update();
        return response()->json([
            "status" => "ok",
            "Message" => "Space  update successfully",
        ]);

    }

    public function delete(Request $request)
    {
        $id = $request->id;
        SpaceLets::where('id', $id)->first()->delete();
        return response()->json([
            "status" => "ok",
            "msg" => "Space account deleted",
        ]);

    }
}