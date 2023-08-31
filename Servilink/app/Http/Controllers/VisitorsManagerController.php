<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\estateuser;
use App\Models\User;
use App\Models\VisitorsManager;

use App\Models\Security;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class VisitorsManagerController extends Controller
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
            $today = date("Y-m-d");
            $tRequest = VisitorsManager::join('estateusers', 'estateusers.user_id', 'visitors_managers.user_id')
                ->where('estateusers.manager_user_id', $user->id)->whereDate('visitors_managers.created_at', $today)->count();
            $usedKey = VisitorsManager::where('visitors_managers.entry_status', 1)
                ->join('estateusers', 'estateusers.user_id', 'visitors_managers.user_id')
                ->where('estateusers.manager_user_id', $user->id)->whereDate('visitors_managers.created_at', $today)->count();
            $unusedKey = VisitorsManager::where('visitors_managers.entry_status', 0)
                ->join('estateusers', 'estateusers.user_id', 'visitors_managers.user_id')
                ->where('estateusers.manager_user_id', $user->id)->whereDate('visitors_managers.created_at', $today)->count();
            return view('manager.visitor_manager', compact('tRequest', 'usedKey', 'unusedKey'));
        } else if ($user->role == 4) {
            $user = Auth::user();
            $date = Carbon::now()->format('Y-m-d');
            $time = Carbon::now()->format('H:i');
            return view('resident.visitor_manager', compact('user', 'date', 'time'));
        }
    }

    public function loadStat()
    {
        $user = Auth::user();
        $tVisitor = VisitorsManager::where('user_id', $user->id)->where('exit_status', 1)->count();
        $this_month = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->addDay()];
        $today = date("Y-m-d");
        $mVisitor = VisitorsManager::where('user_id', $user->id)->where('exit_status', 1)->whereBetween('created_at', $this_month)->count();
        $todayVisitor = VisitorsManager::where('user_id', $user->id)->where('exit_status', 1)->whereDate('created_at', $today)->count();
        $entryreq = VisitorsManager::where('user_id', $user->id)->whereDate('created_at', $today)->count();
        return response()->json([
            "status" => "true",
            "tVisitor" => $tVisitor,
            "mVisitor" => $mVisitor,
            "todayVisit" => $todayVisitor,
            "entryreq" => $entryreq,
        ]);

    }

    public function getVisitors()
    {
        $user = Auth::user();
        $today = date("Y-m-d");
        $visitorsManager = VisitorsManager::join('estateusers', 'estateusers.user_id', 'visitors_managers.user_id')
            ->where('estateusers.manager_user_id', $user->id)->whereDate('visitors_managers.created_at', $today)->orderBy('visitors_managers.id', 'desc')->get();
        foreach ($visitorsManager as $key => $value) {
            # code...
            $value->name = User::where('id', $value->user_id)->value('name');
            $value->gen_time = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:m:s');
        }
        return DataTables::of($visitorsManager)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                &nbsp; &nbsp;
                <a class="delete" data-id="' . $row->id . '"
                 title="delete" ><i class="fa fa-trash text-danger"></i></a>
                 &nbsp; &nbsp;
                 <a class="share"  data-name="' . $row->name . '"data-id="' . $row->id . '" data-token="' . $row->visiting_token . '"
                  title="share" ><i class="fa fa-whatsapp" style="color:#075e54"></i></a>
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
    public function loadVisitors()
    {
        $user = Auth::user();
        $visitorsManager = VisitorsManager::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        foreach ($visitorsManager as $key => $value) {
            # code...
            $value->name = $user->name;
            $value->gen_time = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:m:s');
        }
        return DataTables::of($visitorsManager)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                &nbsp; &nbsp;
                <a class="delete" data-id="' . $row->id . '"
                 title="delete" ><i class="fa fa-trash text-danger" style="font-size:20px"></i></a>
                 &nbsp; &nbsp;
                 <a class="share"  data-name="' . $row->name . '"data-id="' . $row->id . '" data-token="' . $row->visiting_token . '"
                  title="share" ><i class="fa fa-share-alt-square " style="font-size:20px"></i></a>
                 ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function deleteAccess(Request $request)
    {
        $id = $request->id;
        $visit =VisitorsManager::where('id', $id)->first();
        if($visit){
            $visit->delete();
        }
        return response()->json([
            "status" => "ok",
            "msg" => "Resident deleted",
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateToken(Request $request)
    {
        \Log::info($request);
        $user = Auth::user();
        $visitorsManager = new VisitorsManager();
        $visitorsManager->user_id = $user->id;
        $token = rand(10, 50) . rand(40, 80) . rand(20, 99);
        $visitorsManager->visitor_name = $request->visitorname;
        $visitorsManager->visitornumber = $request->visitornumber;
        $visitorsManager->visiting_token = $token;
        $visitorsManager->valid_period = $request->period;
        $visitorsManager->entry_date = $request->entrydate;
        $visitorsManager->entry_status = false;
        $visitorsManager->exit_status = false;
        $time_24 = date("h:i", strtotime($request->entrytime));
        
          \Log::info($time_24);
       
        $eTime = Carbon::createFromFormat('Y-m-d H:i', $request->entrydate." ".$time_24);
        $visitorsManager->entry_time = $time_24;
        $exptime = $eTime->addHours((int) $request->period);
        $visitorsManager->expire_time = $exptime->format('Y-m-d H:i');
        $visitorsManager->save();
        $visitorsManager->name = $user->name;
        return \response()->json(['status' => 'ok', 'data' => $visitorsManager]);
    }

    public function getAllToken()
    {
        $visits = VisitorsManager::where('entry_status', 0)->select('visiting_token','entry_status','expire_time')->get();
          foreach ($visits as $key => $value) {
                $now = date('Y-m-d H:i');
                $expire = $value->expire_time;
                $date1 = Carbon::parse($expire)->format('Y-m-d H:i');
                $date2 = Carbon::createFromFormat('Y-m-d H:i', $now);
           
                if ($date2->gt($date1)) {
                     unset($visits[$key]);
                } 

            }
        return \response()->json(['status' => 'ok', 'data' => $visits]);
    }
    public function UpdateToken(Request $request)
    {
        $visits = VisitorsManager::where('visiting_token',$request->token)->first();
        $visits->entry_status=1;
        $visits->update();
        return \response()->json(['status' => 'ok']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VisitorsManager  $visitorsManager
     * @return \Illuminate\Http\Response
     */
    public function VisitorQuery(Request $request)
    {
        return view('visitors_search');
    }

   
    public function VisitorSearch(Request $request)
    {
        $userid = Auth::id();
        $token ="0";
        $managerid = Security::where('user_id', $userid)->value('manager_user_id');
        $estateuser = User::where('users.name', 'LIKE', "%{$request->queryval}%")
            ->orWhere('users.email', 'LIKE', "%{$request->queryval}%")
            ->join('estateusers', 'users.id', "estateusers.user_id")
            ->where('estateusers.manager_user_id', $managerid)->first();
        if (!$estateuser) {
            $estateuser = estateuser::where('estateusers.phonenumber', 'LIKE', "%{$request->queryval}%")
                ->orWhere('estateusers.meternumber', 'LIKE', "%{$request->queryval}%")
                ->join('users', 'users.id', "estateusers.user_id")->first();
            if (!$estateuser) {
                $token = $request->queryval;
                $userid = VisitorsManager::where('visiting_token', $request->queryval)->value('user_id');
                $estateuser = estateuser::where('estateusers.user_id', $userid)
                    ->join('users', 'users.id', "estateusers.user_id")->first();
            }

        }
      
        if ($estateuser) {
            if ($estateuser->manager_user_id != $managerid) {
                return response()->json([
                    "status" => "false",
                ]);
            }
            return response()->json([
                "status" => "true",
                "userid" => $estateuser->user_id,
                "token" => $token,
            ]);
        } else {
            return response()->json([
                "status" => "false",
            ]);
        }

    }
    public function VisitorData(Request $request)
    {
        $from = $request->start_date;
        $to = $request->end_date;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");

        $resident_id = $request->queryval;

        $user = User::where('id', $resident_id)->first();

        if ($request->token == "0") {
            if (($from == $today && $to == $today) || ($from == $yesterday && $to == $yesterday)) {
                $visitorsManager = VisitorsManager::where('user_id', $resident_id)->whereDate('created_at', $from)->orderBy('created_at', 'desc')->get();
            } else {
                $start = Carbon::parse($from);
                $end = Carbon::parse($to)->addDay();
                $this_month = [$start, $end];
                $visitorsManager = VisitorsManager::where('user_id', $resident_id)->whereBetween('created_at', $this_month)->orderBy('created_at', 'desc')->get();

            }
        } else {
            $visitorsManager = VisitorsManager::where('visiting_token',  $request->token)->get();
        }
        foreach ($visitorsManager as $key => $value) {
            $value->gen_time = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:m:s');
            $value->name = $user->name;
            $value->housenum = $user->estateuser->housenum;
            $value->phone = $user->estateuser->phonenumber;
            $value->estate = Estate::where('id', $user->estateuser->estate_id)->value('name');
        }
        return DataTables::of($visitorsManager)
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VisitorsManager  $visitorsManager
     * @return \Illuminate\Http\Response
     */
    public function edit(VisitorsManager $visitorsManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VisitorsManager  $visitorsManager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VisitorsManager $visitorsManager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VisitorsManager  $visitorsManager
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisitorsManager $visitorsManager)
    {
        //
    }
}