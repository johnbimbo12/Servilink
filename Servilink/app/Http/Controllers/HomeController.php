<?php

namespace App\Http\Controllers;

use App\Helpers\HelperClass;
use App\Models\CreditPurchase;
use App\Models\Estate;
use App\Models\Revenue;
use App\Models\Setting;
use App\Models\User;
use App\Models\VendingTransaction;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 2) {
            return view('manager.dashboard');
        } else if ($user->role == 4) {
            return view('resident.dashboard');
        } else if ($user->role == 1) {
            $this->getWalletBalance();
            $wallet = Setting::where('manager_user_id', $user->id)->value('wallet_balance');
            $managers = User::where('role', 2)->count();
            $estates = Estate::count();
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $this_month = [$start, $end];
            $power = VendingTransaction::where('vend_utility', 0)->where('verified', 1)->whereBetween('created_at', $this_month)->sum('vend_value');
            $water = VendingTransaction::where('vend_utility', 1)->where('verified', 1)->whereBetween('created_at', $this_month)->sum('vend_value');
            $credit = CreditPurchase::where('pay_status', 0)->whereBetween('created_at', $this_month)->sum('amount');
            $revenue = Revenue::whereBetween('created_at', $this_month)->sum('amount');
            $tsales = $power + $water;

            $utilitysale = VendingTransaction::where('vending_transactions.verified', 1)->orderBy('vending_transactions.id', 'desc')
                ->join('managers', 'managers.user_id', 'vending_transactions.merchant_id')->limit(10)->select('vending_transactions.*', 'managers.name')->get();
            $revenueincome = Revenue::orderBy('revenues.id', 'desc')->where('amount', '>', 0)
                ->join('managers', 'managers.user_id', 'revenues.manager_user_id')->limit(10)->select('revenues.*', 'managers.name')->limit(10)->get();
            return view('admin.dashboard', compact('wallet', 'managers', 'estates', 'power', 'water', 'credit', 'revenue', 'tsales', 'utilitysale', 'revenueincome'));
        } else if ($user->role == 5) {
            return view('visitors_search');
        }
    }

    public function getWalletBalance()
    {
        try {
            //code...
            $params = [];
            $url = config('hinge.hingeurl') . "wallet_balance";
            $params['access_key'] = config('hinge.hingekey');
            $resp = Http::withOptions(["verify" => true])
                ->get($url, $params);
            $resp = json_decode($resp);
            $setting = Setting::where('manager_user_id', Auth::id())->first();
            $setting->wallet_balance = $resp;
            $setting->update();
            return response()->json([
                "msg" => "Wallet updated",
                "balance" => $resp,
            ]);

        } catch (\Throwable $th) {
            $resp = Setting::where('manager_user_id', Auth::id())->value('wallet_balance');
            return response()->json([
                "balance" => $resp,
            ]);
        }

    }


    public function Adminstat(Request $request)
    {
        $from = $request->start_date;
        $to = $request->end_date;
        $today = date("Y-m-d");
        $yesterday = Carbon::yesterday()->format("Y-m-d");
        if (($from == $today && $to == $today) || ($from == $yesterday && $to == $yesterday)) {
            $power = VendingTransaction::where('vend_utility', 0)->where('verified', 1)->whereDate('created_at', $from)->sum('amount');
            $water = VendingTransaction::where('vend_utility', 1)->where('verified', 1)->whereDate('created_at', $from)->sum('amount');
            $credit = CreditPurchase::where('pay_status', 0)->whereDate('created_at', $from)->sum('amount');
            $revenue = Revenue::whereDate('created_at', $from)->sum('amount');
            $tsales = $power + $water;

        } else {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to)->addDay();
            $this_month = [$start, $end];
            $power = VendingTransaction::where('vend_utility', 0)->where('verified', 1)->whereBetween('created_at', $this_month)->sum('amount');
            $water = VendingTransaction::where('vend_utility', 1)->where('verified', 1)->whereBetween('created_at', $this_month)->sum('amount');
            $credit = CreditPurchase::where('pay_status', 0)->whereBetween('created_at', $this_month)->sum('amount');
            $revenue = Revenue::whereBetween('created_at', $this_month)->sum('amount');
            $tsales = $power + $water;
        }

        return response()->json([
            "power" => $power,
            "water" => $water,
            "credit" => $credit,
            "revenue" => $revenue,
            'tsale' => $tsales,
        ]);
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function instantPay()
    {
        $estates = Estate::select('name', 'service_charge', 'id')->get();
        $public_key=config('vend.bani_public_key'); 
        $hinge_key=config('hinge.hingekey');
        return view('payment', compact('estates','public_key','hinge_key'));

    }

    public function feedback(Request $request)
    {
        $msg = $request->msg;
        $status = $request->status;
        return view('thankyou', compact('status', 'msg'));
    }

   
    public function changepassword(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $password = $request->password;
            $confirmpwd = $request->password_confirmation;
            if ($password == $confirmpwd) {
                $user->password = Hash::make($request->password);
                $user->update();
                return response()->json([
                    "status" => "ok",
                    "Message" => "Password updated",
                ]);
            }
            return response()->json([
                "status" => "info",
                "Message" => "Wrong confirm Passwords",
            ]);
        }
    }


    public function passwordchange(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $password = $request->password;
            $confirmpwd = $request->password_confirmation;
            if ($password == $confirmpwd) {
                $user->password = Hash::make($request->password);
                $user->update();
                return redirect()->back()->with("success", "Passwords Reset successfully, Kindly login");
            }
            return redirect()->back()->with("error", "Wrong confirm Passwords");
        } else {
            return redirect()->back()->with("error", "Email does not exist!!!");
        }
    }

    public function resetpassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            HelperClass::ResetPass($request->email);
            $helper = new HelperClass();
            $message = view('email.resetpassword')->render();
            $helper = new HelperClass();
            $helper->PHPMailerNotify($request->email, "Password Reset", $message);
            return redirect()->back()->with("success", "Reset link sent to your email");
        } else {
            return redirect()->back()->with("error", "Email does not exist!!!");
        }
    }

    public function passwordreset(Request $request)
    {
        return view('auth.passwords.reset');
    }

}