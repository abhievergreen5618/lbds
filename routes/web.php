<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Common\RequestController;
use App\Http\Controllers\Admin\InspectionController;
use App\Http\Controllers\Admin\Invoice\SendInvoiceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
Route::get('/', function() {
    return view('auth.login'); 
});

Auth::routes();


Route::controller(UserController::class)->group(function () {
    Route::get('/agency-register', 'create')->name('agency-user');
    Route::post('/agency-user/insert', 'store')->name('agency-insert');
});

Route::controller(RequestController::class)->group(function () {
    Route::get('/request', 'index')->name('admin.request.create');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/agency-register',[App\Http\Controllers\UserController::class, 'create'])->name('agency-user');
Route::post('/agency-user/insert',[App\Http\Controllers\UserController::class, 'store'])->name('agency-insert');

Route::group(['middleware' => 'auth'], function () {
Route::controller(InspectionController::class)->group(function () {
    Route::get('/add-inspection-type', 'index')->name('admin.create.addinspectiontype');
    Route::get('/update-inspection-type','update')->name('admin.update.inspectiontype');
    Route::post('/create-inspection-type','create')->name('admin.create.createinspectiontype');
    Route::get('/all-inspection-type','show')->name('admin.allinspectiontype');
    Route::post('/inspectiontypedetails','display')->name('inspectiontypedetails');
    Route::post('/inspection-type-status-update','status')->name('inspection-type-status-update');
    Route::post('/inspection-type-delete','destroy')->name('inspection-type-delete');
});
Route::controller(SendInvoiceController::class)->group(function () {
    Route::get('/add-send-invoice', 'index')->name('admin.create.addsendinvoice');
    Route::get('/update-send-invoice','update')->name('admin.update.sendinvoice');
    Route::post('/create-send-invoice','create')->name('admin.create.sendinvoice');
    Route::get('/all-send-invoice','show')->name('admin.allsendinvoice');
    Route::post('/sendinvoicedetails','display')->name('sendinvoicedetails');
    Route::post('/send-invoice-status-update','status')->name('send-invoice-status-update');
    Route::post('/send-invoice-delete','destroy')->name('send-invoice-delete');
});
});

Auth::routes(['verify' => true]);


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');