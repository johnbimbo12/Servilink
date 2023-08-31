<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//
Route::get('/offline', function () {
    return view('vendor.laravelpwa.offline');
});
Route::get('/privacy_policy', function () {
    return view('privacypolicy');
});
Auth::routes(['register' => false]);
Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/instantPay', [App\Http\Controllers\HomeController::class, 'InstantPay'])->name('instantpay');
Route::get('/feedback', [App\Http\Controllers\HomeController::class, 'feedback'])->name('feedback');

Route::post('/passwordchange', [App\Http\Controllers\HomeController::class, 'changepassword'])->name('changepassword');

Route::post('/password/change', [App\Http\Controllers\HomeController::class, 'passwordchange'])->name('password.change');
Route::post('/passwordreset', [App\Http\Controllers\HomeController::class, 'resetpassword'])->name('reset.password');
Route::get('/reset/password', [App\Http\Controllers\HomeController::class, 'passwordreset']);

Route::post('/payprocess', [App\Http\Controllers\ChargesPaymentController::class, 'initialize'])->name('payprocess');

Route::post('/purchaseunit', [App\Http\Controllers\PowerManagerController::class, 'purchaseunit'])->name('purchaseunit');

Route::get('/getmeter', [App\Http\Controllers\PowerManagerController::class, 'getMeter'])->name('getmeter');
Route::get('/service/callback', [App\Http\Controllers\ChargesPaymentController::class, 'callback'])->name('service.callback');
Route::get('/credit/callback', [App\Http\Controllers\CreditPurchaseController::class, 'callback'])->name('credit.callback');
Route::get('/callback', [App\Http\Controllers\PowerManagerController::class, 'callback'])->name('callback');

Route::post('/paystack/webhook', [App\Http\Controllers\PowerManagerController::class, 'webhook'])->name('webhook');

Route::get('/checkmeter', [App\Http\Controllers\PowerManagerController::class, 'CheckMeter'])->name('checkmeter');

Route::get('/manager/transaction', [App\Http\Controllers\PaymentTransactController::class, 'Transactions'])->name('transactions')->middleware('auth');

Route::get('/filtertransaction/{type}', [App\Http\Controllers\PaymentTransactController::class, 'FilterTransactions'])->middleware('auth');

Route::get('/power/management', [App\Http\Controllers\PowerManagerController::class, 'index'])->middleware('auth')->name('power.manage');
Route::get('/visitor/management', [App\Http\Controllers\VisitorsManagerController::class, 'index'])->middleware('auth')->name('visitor.manage');

Route::get('/water/management', [App\Http\Controllers\WaterManagerController::class, 'index'])->middleware('auth')->name('water.manage');
Route::get('/message', [App\Http\Controllers\MessagingController::class, 'index'])->middleware('auth')->name('messaging');

Route::post('/message/save', [App\Http\Controllers\MessagingController::class, 'store'])->middleware('auth')->name('message.save');
Route::get('/service/fee', [App\Http\Controllers\ChargesPaymentController::class, 'index'])->middleware('auth')->name('service.charges');
Route::get('/message/details/{id}', [App\Http\Controllers\MessagingController::class, 'show'])->middleware('auth')->name('message.details');

Route::get('/setting', [App\Http\Controllers\SettingController::class, 'index'])->middleware('auth')->name('setting');

Route::get('/visitor/search', [App\Http\Controllers\VisitorsManagerController::class, 'VisitorSearch'])->middleware('auth')->name('visitor.search');
Route::get('/visitor/data', [App\Http\Controllers\VisitorsManagerController::class, 'VisitorData'])->middleware('auth')->name('visitor.data');

Route::get('/booking', [App\Http\Controllers\BookingController::class, 'index'])->middleware('auth')->name('index.booking');
Route::get('/booking/show', [App\Http\Controllers\BookingController::class, 'show'])->middleware('auth')->name('show.booking');
Route::get('/space', [App\Http\Controllers\SpaceLetsController::class, 'loadspace'])->middleware('auth')->name('load.space');
Route::get('/space/available', [App\Http\Controllers\SpaceLetsController::class, 'availablespace'])->middleware('auth')->name('avaialble.space');
Route::get('/emergency', [App\Http\Controllers\EmergencyController::class, 'index'])->middleware('auth')->name('emergency');
//Administrative Routes

Route::get('/test/sms', [App\Http\Controllers\MessagingController::class, 'testsms'])->name('test.sms');

Route::get('/confirm/vending', [App\Http\Controllers\VendingTransactionController::class, 'ConfirmAdminVending']);


Route::get('/verify/customer', [App\Http\Controllers\PaymentGatewayController::class, 'verifyCustomer'])->name('verify.customer');
Route::get('/bani/verify/payment', [App\Http\Controllers\PaymentGatewayController::class, 'verifyPayment'])->name('bani.verify');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/managers', [App\Http\Controllers\ManagersController::class, 'index'])->name('managers');
    Route::get('/estates', [App\Http\Controllers\EstateController::class, 'index'])->name('estates');
    Route::get('/adminstat', [App\Http\Controllers\HomeController::class, 'Adminstat'])->name('admin.stat');
    Route::get('/revenue', [App\Http\Controllers\RevenueController::class, 'index'])->name('revenue');

    Route::post('/delete/manager', [App\Http\Controllers\ManagersController::class, 'deleteAccount'])->name('delete.manager');
    Route::post('/add/manager', [App\Http\Controllers\ManagersController::class, 'store'])->name('add.manager');

    Route::post('edit/manager', [App\Http\Controllers\ManagersController::class, 'edit'])->name('edit.manager');
    Route::post('/estate/delete', [App\Http\Controllers\EstateManagerController::class, 'deleteEstate'])->name('estate.delete');
    Route::get('/show/manager', [App\Http\Controllers\ManagersController::class, 'show'])->name('show.manager');
    Route::get('/show/estate', [App\Http\Controllers\EstateController::class, 'show'])->name('show.estate');

    Route::post('/edit/estate', [App\Http\Controllers\EstateController::class, 'edit'])->name('edit.estate');
    Route::get('/power/history', [App\Http\Controllers\PowerManagerController::class, 'VendHistory'])->name('vend.history');
    Route::get('/vend/stat', [App\Http\Controllers\PowerManagerController::class, 'VendStat'])->name('vend.stat');
    Route::get('/revenue/stat', [App\Http\Controllers\RevenueController::class, 'RevenueStat'])->name('stat.revenue');
    Route::get('/revenue/load', [App\Http\Controllers\RevenueController::class, 'RevenueDetails'])->name('revenue.load');
    Route::get('/wallet/balance', [App\Http\Controllers\HomeController::class, 'getWalletBalance'])->name('wallet.balance');
    
    Route::post('/admin/vend', [App\Http\Controllers\PowerManagerController::class, 'AdminVend'])->name('admin.vend');

});

//End of Administrative

//Facility Manager Routes

Route::group(['middleware' => ['manager']], function () {

    Route::get('/diesel/management', [App\Http\Controllers\DieselManagerController::class, 'index'])->name('diesel.manage');
    Route::get('/mpowerstat', [App\Http\Controllers\PowerManagerController::class, 'loadpowerstat']);
    Route::get('/loadvendtransact', [App\Http\Controllers\PowerManagerController::class, 'getVendTransactions']);

    Route::get('/manager/estate', [App\Http\Controllers\EstateManagerController::class, 'index'])->name('manage.estate');
    Route::get('/load/estate', [App\Http\Controllers\EstateManagerController::class, 'LoadEstate'])->name('load.estate');
    Route::post('/delete/estate', [App\Http\Controllers\EstateManagerController::class, 'deleteEstate'])->name('delete.estate');

    Route::post('/create/estate', [App\Http\Controllers\EstateManagerController::class, 'store'])->name('create.estate');

    Route::get('/getresident', [App\Http\Controllers\EstateuserController::class, 'show'])->name('show.resident');
    Route::post('/editresident', [App\Http\Controllers\EstateuserController::class, 'edit'])->name('edit.resident');
    Route::post('/delete/account', [App\Http\Controllers\EstateuserController::class, 'deleteAccount'])->name('delete.account');
    Route::get('/loadstat', [App\Http\Controllers\EstateuserController::class, 'loadstat'])->name('loadstat');
    Route::post('/registeruser', [App\Http\Controllers\EstateuserController::class, 'store'])->name('store.user');
    Route::get('/load/resident', [App\Http\Controllers\EstateuserController::class, 'LoadResident'])->name('load.resident');
    Route::get('/manager/resident', [App\Http\Controllers\EstateuserController::class, 'index'])->name('residents');
    Route::get('/load/revenue', [App\Http\Controllers\PaymentTransactController::class, 'RevenueTransactions'])->name('load.revenue');
    Route::get('/revenue/stats', [App\Http\Controllers\PaymentTransactController::class, 'RevenueStat'])->name('revenue.stat');
    Route::get('/service/transaction', [App\Http\Controllers\ChargesPaymentController::class, 'ServiceTransactions'])->name('service.transaction');
    Route::get('/service/stats', [App\Http\Controllers\ChargesPaymentController::class, 'ServiceStat'])->name('service.stat');
     
    Route::post('/service/update', [App\Http\Controllers\ChargesPaymentController::class, 'Edit'])->name('service.update');
    
    Route::post('/pay/service/', [App\Http\Controllers\ChargesPaymentController::class, 'PayServiceFee'])->name('pay.service');
    Route::post('/update/bank/', [App\Http\Controllers\SettingController::class, 'BankDetails'])->name('update.bank');
    Route::post('/update/account/', [App\Http\Controllers\SettingController::class, 'UpdateAccount'])->name('update.account');

    Route::get('/get/resident/', [App\Http\Controllers\EstateuserController::class, 'getResident'])->name('get.resident');
    Route::get('/get/vistor', [App\Http\Controllers\VisitorsManagerController::class, 'getVisitors'])->name('get.visitors');

    Route::get('/load/messages', [App\Http\Controllers\MessagingController::class, 'loadMessages'])->name('load.message');

    Route::get('/security', [App\Http\Controllers\SecurityController::class, 'index'])->name('index.security');
    Route::get('/security/load', [App\Http\Controllers\SecurityController::class, 'LoadSecurity'])->name('load.security');
    Route::post('/security/add', [App\Http\Controllers\SecurityController::class, 'store'])->name('store.security');
    Route::get('/security/show', [App\Http\Controllers\SecurityController::class, 'show'])->name('show.security');
    Route::post('/security/delete', [App\Http\Controllers\SecurityController::class, 'delete'])->name('delete.security');
    Route::post('/security/edit', [App\Http\Controllers\SecurityController::class, 'edit'])->name('edit.security');

    Route::get('/space', [App\Http\Controllers\SpaceLetsController::class, 'index'])->name('index.space');
    Route::get('/space/show', [App\Http\Controllers\SpaceLetsController::class, 'show'])->name('show.space');
    Route::post('/space/add', [App\Http\Controllers\SpaceLetsController::class, 'store'])->name('store.space');
    Route::post('/space/delete', [App\Http\Controllers\SpaceLetsController::class, 'delete'])->name('delete.space');
    Route::post('/space/edit', [App\Http\Controllers\SpaceLetsController::class, 'edit'])->name('edit.space');
});

//End of Facility Manager Routes

//Transaction query routes

Route::group(['middleware' => ['resident']], function () {
    Route::get('/power/details', [App\Http\Controllers\PowerManagerController::class, 'PowerDetails'])->name('power.details');
    Route::get('/power/stats', [App\Http\Controllers\PowerManagerController::class, 'PowerStat'])->name('power.stat');
    Route::get('/power/buy', [App\Http\Controllers\PowerManagerController::class, 'PowerBuy'])->name('power.buy');
    Route::get('/vending/verify/{txref}', [App\Http\Controllers\PowerManagerController::class, 'VendVerify'])->name('vend.verify');
    
    Route::get('/paycredit', [App\Http\Controllers\CreditPurchaseController::class, 'paycredit'])->name('paycredit');

    Route::get('/message/load', [App\Http\Controllers\MessagingController::class, 'getMessages'])->name('message.load');
    Route::delete('/message/delete', [App\Http\Controllers\MessagingController::class, 'delete'])->name('delete.request');

    Route::get('/load/transaction', [App\Http\Controllers\PaymentTransactController::class, 'LoadTransactions'])->name('load.transactions');
    Route::get('/load/service', [App\Http\Controllers\ChargesPaymentController::class, 'LoadTransactions'])->name('load.service');
    Route::post('/generate/token', [App\Http\Controllers\VisitorsManagerController::class, 'generateToken'])->name('generate.visitortoken');
    Route::get('/load/token', [App\Http\Controllers\VisitorsManagerController::class, 'loadVisitors'])->name('load.visitors');
    Route::get('/token/stat', [App\Http\Controllers\VisitorsManagerController::class, 'loadStat'])->name('visitor.stat');
    Route::post('/token/delete', [App\Http\Controllers\VisitorsManagerController::class, 'deleteAccess'])->name('delete.accesskey');

    Route::post('/booking/add', [App\Http\Controllers\BookingController::class, 'store'])->name('store.booking');
    Route::post('/booking/delete', [App\Http\Controllers\BookingController::class, 'delete'])->name('delete.booking');
    Route::post('/booking/edit', [App\Http\Controllers\BookingController::class, 'edit'])->name('edit.booking');

    Route::get('/load/space', [App\Http\Controllers\SpaceLetsController::class, 'availablespace'])->name('load.space');
    
    Route::post('/add/emergency', [App\Http\Controllers\EmergencyContactsController::class, 'store'])->middleware('auth')->name('store.contact');
    Route::get('/show/emergency', [App\Http\Controllers\EmergencyContactsController::class, 'show'])->middleware('auth')->name('show.contact');
    Route::post('/edit/emergency', [App\Http\Controllers\EmergencyContactsController::class, 'edit'])->middleware('auth')->name('edit.contact');    
    Route::post('/delete/emergency', [App\Http\Controllers\EmergencyContactsController::class, 'deleteContact'])->middleware('auth')->name('delete.contact');

});