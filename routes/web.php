<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Common\RequestController;
use App\Http\Controllers\Admin\InspectionController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::controller(UserController::class)->group(function () {
    Route::get('/agency-register', 'create')->name('agency-user');
    Route::post('/agency-user/insert', 'store')->name('agency-insert');
});

Route::controller(RequestController::class)->group(function () {
    Route::get('/request', 'index')->name('admin.request.create');
});


// Route::get('/agency-register',[App\Http\Controllers\UserController::class, 'create'])->name('agency-user');
Route::post('/agency-user/insert',[App\Http\Controllers\UserController::class, 'store'])->name('agency-insert');


Route::controller(InspectionController::class)->group(function () {
    Route::get('/add-inspection-type', 'index')->name('admin.create.addinspectiontype');
    Route::get('/update-inspection-type', 'index')->name('admin.update.inspectiontype');
    Route::post('/create-inspection-type','create')->name('admin.create.createinspectiontype');
    Route::get('/all-inspection-type','show')->name('admin.allinspectiontype');
});

Route::post('/inspectiontypedetails','display')->name('inspectiontypedetails');

