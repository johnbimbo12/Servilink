<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Estate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\VendingTransaction;
use App\Models\ChargesPayment;
use Illuminate\Support\Str;

use Carbon\Carbon;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role == 4) {
                $user->access_token = Str::uuid();
                $user->update();
                $userdata = $user->estateuser;
                $user->estate = Estate::where('id', $userdata->estate_id)->select('name', 'service_charge')->first();
                 $cPayment = ChargesPayment::where('meternumber',  $userdata->meternumber)->orderBy('id', 'desc')->value('payment_date');
                 $expireDate = Carbon::parse($cPayment)->addMonths(1)->format('Y-m-d');
                 $lastunit = VendingTransaction::where('meterPan', $userdata->meternumber)->orderBy('id', 'desc')->value('unitsActual');
                 if($lastunit){
                        $user->lastunit=$lastunit;
                 }else{
                    $user->lastunit=0;
                 }
                  if($expireDate){
                         $user->renewal_date=$expireDate;
                 }else{
                    $user->renewal_date= "No payment";
                 }
                
                $success['user'] = $user;
                return $this->sendResponse($success, 'User login successfully.');
            }
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);

        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
    public function logout(Request $request)
    {
        $user = User::where('access_token', $request->token)->first();
        $user->remember_token = null;
        $user->update();
        $success['remember_token'] = null;
        return $this->sendResponse($success, 'User logout successfully.');
    }
    public function userData(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if ($user) {
                $userdata = $user->estateuser;
                $user->estate = Estate::where('id', $userdata->estate_id)->select('name', 'service_charge')->first();
                 $cPayment = ChargesPayment::where('meternumber',  $userdata->meternumber)->orderBy('id', 'desc')->value('payment_date');
                 $expireDate = Carbon::parse($cPayment)->addMonths(1)->format('Y-m-d');
                 $lastunit = VendingTransaction::where('meterPan', $userdata->meternumber)->orderBy('id', 'desc')->value('unitsActual');
                if($lastunit){
                        $user->lastunit=$lastunit;
                 }else{
                    $user->lastunit=0;
                 }
                  if($expireDate){
                         $user->renewal_date=$expireDate;
                 }else{
                    $user->renewal_date= "No payment";
                 }
                $success['user'] = $user;
            return $this->sendResponse($success, 'User data retrived.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}