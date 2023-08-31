<?php

namespace App\Http\Controllers;

use App\Helpers\HelperClass;
use App\Models\ChargesPayment;
use App\Models\CreditPurchase;
use App\Models\Estate;
use App\Models\estateuser;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Paystack;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class EstateuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estates = Estate::where('manager_user_id', Auth::id())->select('name', 'service_charge', 'id')->get();
        return view('manager.residents_manager', compact('estates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function LoadResident()
    {
        $user = Auth::user();
        $resident = estateuser::where('estateusers.manager_user_id', $user->id)->join('users', 'estateusers.user_id', 'users.id')->get();
        foreach ($resident as $key => $value) {
            $outstanding = "None";
            $cPayment = ChargesPayment::where('meternumber', $value->meternumber)->orderBy('id', 'desc')->first();
            $estate = Estate::where('id', $value->estate_id)->value('name');
            if ($cPayment) {
                $payday = $cPayment->payment_date;
                $expireDate = Carbon::parse($payday)->addMonths(1)->format('Y-m-d');
                $today = date("Y-m-d");
                $exDate = date('Y-m-d', strtotime($expireDate));
                $nowDate = date('Y-m-d', strtotime($today));

                if ($nowDate > $exDate) {
                    $outstanding = "Service Charge";
                } else {
                    $creditpurchase = CreditPurchase::where('user_id', $value->user_id)->where('pay_status', 0)->orderBy('id', 'desc')->first();
                    if ($creditpurchase) {
                        $outstanding = "On-Credit Purchase";
                    }
                }
            } else {

                $outstanding = "Service Charge";
            }
            $value->pay_status = $outstanding;
            $value->estate = $estate;

            if ($value->status == 0) {
                $value->lock_status = "Blocked";
            } else {
                $value->lock_status = "Enabled";
            }
        }
        return DataTables::of($resident)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                &nbsp; &nbsp;
                <a class="edit" data-toggle="modal" data-target="#modal-edit-resident" data-id="' . $row->id . '"
                data-placement="top" title="Edit" ><i class="fa fa-edit text-success"></i></a>
                &nbsp; &nbsp;
                <a class="delete" data-id="' . $row->user_id . '"
                 title="Edit" ><i class="fa fa-trash text-danger"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->file == 0) {
            $manager_user_id = Auth::user()->id;
            $user = User::where('email', $request->email)->first();
            if ($user) {
                  return response()->json([
                    "status" => "error",
                    "Message" => "Email already registered",
                ]);
            } else {
                $user = new User();
                $user->email = $request->email;
                $user->name = $request->name;
                $user->role = 4;
                $user->password = Hash::make($request->phone);
                $user->save();
            }
            $meterpan = estateuser::where('meternumber', $request->meterpan)->first();
            $vendprovider = Estate::where('id', $request->estate)->value('vend_provider');
            if ($meterpan) {
                $user->delete();
                 return response()->json([
                    "status" => "error",
                    "Message" => "Meter number not unique, Resident account not created",
                ]);
            } else {
                $estateuser = new estateuser();
                $estateuser->phonenumber = $request->phone;
                $estateuser->meternumber = $request->meterpan;
                $estateuser->waternumber = $request->water;
                $estateuser->estate_id = $request->estate;
                $estateuser->housenum = $request->housenum;
                if ($request->newmeter == "on") {
                    $estateuser->newPMeter= 1;
                }else{
                    $estateuser->newPMeter=0;
                }
               
                $estateuser->manager_user_id = $manager_user_id;
                $estateuser->vend_provider = $vendprovider;
                $estateuser->user_id = $user->id;
                $estateuser->save();
            }

            if ($request->paidservicefee == "on") {
                $from = Carbon::now()->endOfMonth();                
                $to =  Carbon::parse($request->paymentdate);   
                $diff_in_days = $to->diffInDays($from);
                $paydue= Carbon::parse($request->paymentdate)->endOfMonth()->addMonths($request->nummonth)->format("Y-m-d");
                if( $diff_in_days >10 ){
                    $paydue= Carbon::parse($request->paymentdate)->startOfMonth()->addMonths($request->nummonth)->format("Y-m-d");
                }
                $reference =Paystack::genTranxRef();
                $amount = Estate::where('id', $request->estate)->value('service_charge');
                $charged = new ChargesPayment();
                $charged->estate_id = $request->estate;
                $charged->phonenumber = $request->phone;
                $charged->meternumber = $request->meterpan;
                $charged->txref = $reference;
                $charged->user_id = $user->id;
                $charged->amount = $amount;
                $charged->email = $request->email;
                $charged->payment_date = $paydue;
                $charged->no_of_month = $request->nummonth;
                $charged->save();
            }
            $helper = new HelperClass();
            $helper->sendRegistrationEmail($request->email, "Account Creation", $user);
            return response()->json([
                "status" => "ok",
                "Message" => "Resident account create successfully",
            ]);
        } else {

            $this->validate($request, [
                'file' => 'required|file|mimes:xls,xlsx',
            ]);

            $the_file = $request->file('file');
            if ($the_file) {

                try {
                    $spreadsheet = IOFactory::load($the_file->getRealPath());
                    $sheet = $spreadsheet->getActiveSheet();
                    $row_limit = $sheet->getHighestDataRow();
                    $column_limit = $sheet->getHighestDataColumn();
                    $row_range = range(2, $row_limit);
                    $column_range = range('G', $column_limit);

                    foreach ($row_range as $row) {

                        $name = $sheet->getCell('A' . $row)->getValue();
                        $email = $sheet->getCell('B' . $row)->getValue();
                        $phone = $sheet->getCell('C' . $row)->getValue();
                        $house = $sheet->getCell('D' . $row)->getValue();
                        $estate = $sheet->getCell('E' . $row)->getValue();
                        $meter = $sheet->getCell('F' . $row)->getValue();
                        $water = $sheet->getCell('G' . $row)->getValue();
                        $newmeter= $sheet->getCell('H' . $row)->getValue();

                        if (empty($name) && empty($email) && empty($phone) && empty($house) && empty($estate) && empty($meter) && empty($water)) {
                            break;
                        }
                        \Log::info($name . "," . $email . "," . $phone . " ," . $house . " ," . $estate . " ," . $meter . ", " . $water);
                        $manager_user_id = Auth::user()->id;

                        $estatedata = Estate::where(DB::raw('lower(name)'), strtolower($estate))->where('manager_user_id', $manager_user_id)->first();
                        if ($estatedata) {
                        } else {
                            return redirect()->back()->with("error",'Estate not found, estate registration is require before proceeding');
                            break;
                        }
                        $user = User::where('email', $email)->first();

                        if ($user) {
                            $return;
                        } else {
                            $user = new User();
                            $user->email = $email;
                            $user->name = $name;
                            $user->role = 4;
                            $user->password = Hash::make($phone);
                            $user->save();
                        }
                        $meterpan = estateuser::where('meternumber', $meter)->first();

                        if ($meterpan) {
                            $user->delete();
                            return;
                        } else {
                            $estateuser = new estateuser();
                            $estateuser->phonenumber = $phone;
                            $estateuser->meternumber = $meter;
                            $estateuser->waternumber = $water;
                            $estateuser->estate_id = $estatedata->id;
                            $estateuser->housenum = $house;
                            $estateuser->manager_user_id = $manager_user_id;
                            $estateuser->vend_provider =0;
                            if ($newmeter == "yes" || $newmeter == "Yes") {
                                $estateuser->newPMeter= 1;
                            }else{
                                $estateuser->newPMeter=0;
                            }
                            $estateuser->user_id = $user->id;
                            $estateuser->save();
                        }
                        $reference =Paystack::genTranxRef();
                        $amount = $estatedata->service_charge;
                        $from = Carbon::now()->endOfMonth();                
                        $to =  Carbon::today();   
                        $diff_in_days = $to->diffInDays($from);
                        $paydate = Carbon::today()->endOfMonth()->format("Y-m-d");
                        if ($diff_in_days > 10) {
                            $paydate = Carbon::today()->startOfMonth()->format("Y-m-d");
                        }
                        $charged = new ChargesPayment();
                        $charged->estate_id = $estatedata->id;
                        $charged->phonenumber = $phone;
                        $charged->meternumber = $meter;
                        $charged->txref = $reference;
                        $charged->user_id = $user->id;
                        $charged->amount = $amount;
                        $charged->email = $email;
                        $charged->payment_date = $paydate;
                        $charged->no_of_month = 1;
                        $charged->save();

                        $helper = new HelperClass();
                        $helper->sendRegistrationEmail($email, "Account Creation", $user);

                    }

                } catch (Exception $e) {

                    return redirect()->back()->with("error",'There was a problem uploading the data!');
                }
            } else {
                return redirect()->back()->with("error",'File not found');
            }
            return redirect()->back()->with("success",'Great! Data has been successfully uploaded.');
        }
    }

    public function checkUploadedFileProperties($extension)
    {
        $valid_extension = array("xlsx"); //Only want csv and excel files
        if (in_array(strtolower($extension), $valid_extension)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\estateuser  $estateuser
     * @return \Illuminate\Http\Response
     */
    public function loadstat()
    {
        $user = Auth::user();
        $resident = estateuser::where('estateusers.manager_user_id', $user->id)->get();
        $debtorcnt = 0;
        foreach ($resident as $key => $value) {
            # code...
            $cPayment = ChargesPayment::where('meternumber', $value->meternumber)->orderBy('id', 'desc')->first();
            if ($cPayment) {
                $payday = $cPayment->payment_date;
                $expireDate = Carbon::parse($payday)->addMonths(1)->format('Y-m-d');
                $today = date("Y-m-d");
                $exDate = date('Y-m-d', strtotime($expireDate));
                $nowDate = date('Y-m-d', strtotime($today));

                if ($nowDate > $exDate) {
                    $debtorcnt++;
                } else {
                    $creditpurchase = CreditPurchase::where('user_id', $value->user_id)->where('pay_status', 0)->orderBy('id', 'desc')->first();
                    if ($creditpurchase) {
                        $debtorcnt++;
                    }
                }
            } else {

                $debtorcnt++;
            }
        }

        return response()->json([
            "status" => "true",
            "tresidents" => count($resident),
            "debtors" => $debtorcnt,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\estateuser  $estateuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $user = User::where('id', $request->user_id)->first();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->update();
        $estateuser = estateuser::where('user_id', $request->user_id)->first();
        $estateuser->phonenumber = $request->phone;
        $estateuser->meternumber = $request->meterpan;
        $estateuser->waternumber = $request->waternumber;
        $estateuser->housenum = $request->housenum;
        $estateuser->status = $request->status;
        $estateuser->update();
        return response()->json([
            "status" => "ok",
            "Message" => "resident account update successfully",
        ]);

    }
    public function show(Request $request)
    {
        $estateuser = estateuser::where('estateusers.user_id', $request->id)
            ->join('users', 'users.id', 'estateusers.user_id')->first();

        return response()->json([
            "status" => "ok",
            "data" => $estateuser,
        ]);

    }

    public function getResident(Request $request)
    {
        //name, email, phonenumber, meternumber
        $estateuser = User::where('users.name', 'LIKE', "%{$request->queryval}%")
            ->orWhere('users.email','LIKE', "%{$request->queryval}%")
            ->join('estateusers', 'users.id', "estateusers.user_id")->first();
        if (!$estateuser) {
            $estateuser = estateuser::where('estateusers.phonenumber', 'LIKE', "%{$request->queryval}%")
                ->orWhere('estateusers.meternumber', 'LIKE', "%{$request->queryval}%")
                ->join('users', 'users.id', "estateusers.user_id")->first();
        }
        if ($estateuser) {
            $payment = ChargesPayment::where('meternumber', $estateuser->meternumber)->orderBy('id', 'desc')->value('payment_date');
            $estateuser->lastpayday = $payment;
            $estateuser->servicefee = Estate::where('id', $estateuser->estate_id)->value('service_charge');
            return response()->json([
                "status" => "ok",
                "data" => $estateuser,
            ]);

        }
        return response()->json([
            "status" => "info",
        ]);

    }

    public function deleteAccount(Request $request)
    {
        $id = $request->id;
        User::where('id', $id)->first()->delete();
        estateuser::where('user_id', $id)->first()->delete();
        return response()->json([
            "status" => "ok",
            "msg" => "Resident deleted",
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\estateuser  $estateuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, estateuser $estateuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\estateuser  $estateuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(estateuser $estateuser)
    {
        //
    }
}