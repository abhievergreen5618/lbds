<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Common\RequestController;
use App\Http\Controllers\Admin\InspectionController;
use App\Http\Controllers\Admin\Invoice\SendInvoiceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\Inspector\InspectorController;
use App\Http\Controllers\Company\Employee\EmployeeController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Common\ProfileController;
use App\Http\Controllers\vendor\Chatify\MessagesListController;
use App\Http\Controllers\vendor\Chatify\MessagesController;
use App\Http\Controllers\Common\JobCalenderController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\Admin\Agency\AgencyController;
use App\Http\Controllers\Admin\Portal\ProtalController;
use App\Http\Controllers\Admin\Agency\AgencyApprovalController;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::controller(UserController::class)->group(function () {
    Route::get('/agency-register', 'create')->name('agency-user');
    Route::post('/agency-user/insert', 'store')->name('agency-insert');
});

Route::controller(RequestController::class)->group(function () {
    Route::get('/request', 'index')->name('admin.request.create');
    Route::get('/request-list', 'show')->name('admin.request.list');
    Route::post('/requestsubmit', 'create')->name('requestsubmit');
    Route::post('/fileuploadrequest', 'upload')->name('fileuploadrequest');
    Route::post('/requestdetails', 'display')->name('requestdetails');
    Route::post('/request-status-update', 'status')->name('request-status-update');
    Route::post('/request-delete', 'destroy')->name('request-delete');
    Route::get('/request-check', 'requestcheck')->name('requestcheck');
    Route::post('/inspectorassign', 'assign')->name('inspectorassign');
    Route::post('/request-delete', 'destroy')->name('request-delete');
    Route::post('/request-cancel', 'cancel')->name('request-cancel');
    Route::post('/request-update', 'update')->name('requestupdate');
    Route::post('/requestschedule', 'schedule')->name('requestschedule');
    Route::get('/filedownload', 'filedownload')->name('filedownload');
    Route::post('/statusupdate', 'statusupdate')->name('statusupdate');

    // company routes
    Route::get('/company-request-list', 'showcompanylist')->name('company.request.list');
    Route::post('/companyrequestdetails', 'displaycompanylist')->name('companyrequestdetails');

    // inspector routes
    Route::get('/inspector-request-list', 'showinspectorlist')->name('inspector.request.list');
    Route::post('/inspectorrequestdetails', 'displayinspectorlist')->name('inspectorrequestdetails');
    Route::post('/request-reschedule', 'reschedule')->name('request-reschedule');
    Route::post('/request-submit-review', 'submitreview')->name('request-submit-review');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/agency-register',[App\Http\Controllers\UserController::class, 'create'])->name('agency-user');
// Route::post('/agency-user/insert',[App\Http\Controllers\UserController::class, 'store'])->name('agency-insert');

Route::group(['middleware' => 'auth'], function () {
    Route::controller(InspectionController::class)->group(function () {
        Route::get('/add-inspection-type', 'index')->name('admin.create.addinspectiontype');
        Route::get('/update-inspection-type', 'update')->name('admin.update.inspectiontype');
        Route::post('/create-inspection-type', 'create')->name('admin.create.createinspectiontype');
        Route::get('/all-inspection-type', 'show')->name('admin.allinspectiontype');
        Route::post('/inspectiontypedetails', 'display')->name('inspectiontypedetails');
        Route::post('/inspection-type-status-update', 'status')->name('inspection-type-status-update');
        Route::post('/inspection-type-delete', 'destroy')->name('inspection-type-delete');
        Route::post('/disableshow', 'disableshow')->name('disableshow');
        Route::post('/inspectiontypedisablelist', 'disablelist')->name('inspectiontypedisablelist');
    });
    Route::controller(SendInvoiceController::class)->group(function () {
        Route::get('/add-send-invoice', 'index')->name('admin.create.addsendinvoice');
        Route::get('/update-send-invoice', 'update')->name('admin.update.sendinvoice');
        Route::post('/create-send-invoice', 'create')->name('admin.create.sendinvoice');
        Route::get('/all-send-invoice', 'show')->name('admin.allsendinvoice');
        Route::post('/sendinvoicedetails', 'display')->name('sendinvoicedetails');
        Route::post('/send-invoice-status-update', 'status')->name('send-invoice-status-update');
        Route::post('/send-invoice-delete', 'destroy')->name('send-invoice-delete');
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/add-employee', 'index')->name('admin.employee.create');
        Route::post('/add-employee', 'create')->name('admin.employee.create');
        Route::get('/employee-list', 'show')->name('admin.employee.view');
        Route::post('/employee-details', 'display')->name('employee-details');
        Route::get('/employee-update', 'update')->name('admin.show.employee');
        Route::post('/submit/update-employee/', 'submitUpdate')->name('admin.employee.update');
        Route::post('/employee-delete', 'destroy')->name('employee-delete');
    });


    Route::controller(InspectorController::class)->group(function () {
        Route::get('/view-inspector', 'index')->name('admin.view.inspector');
        Route::post('/inspectortabledetails', 'display')->name('inspectortabledetails');
        Route::get('/update-inspector', 'update')->name('admin.show.inspector');
        Route::post('submit/update-inspector/', 'submitUpdate')->name('admin.update.inspector');
        Route::get('/add-inspector', 'create')->name('admin.create.addinspector');
        Route::post('/insert-inspector', 'store')->name('admin.insert.insertinspector');
        Route::post('/inspector-delete', 'destroy')->name('inspector-delete');
        Route::post('/inspector-status-update', 'status')->name('inspector-status-update');
        Route::get('inspector/password/password-reset', 'passwordReset')->name('admin.inspector.passwordReset');
        Route::post('inspector/password/submit', 'updatepassword')->name('admin.inspector.Updatepassword');
    });
    // Route::controller(InspectorController::class)->group(function () {
    //     Route::get('/view-inspector','index')->name('admin.view.inspector');
    //     Route::post('/inspectortabledetails','display')->name('inspectortabledetails');
    //     Route::get('/update-inspector','update')->name('admin.show.inspector');
    //     Route::post('submit/update-inspector/','submitUpdate')->name('admin.update.inspector');
    //     Route::get('/add-inspector','create')->name('admin.create.addinspector');
    //     Route::post('/insert-inspector','store')->name('admin.insert.insertinspector');
    //     Route::post('/inspector-delete','destroy')->name('inspector-delete');
    //     Route::post('/inspector-status-update','status')->name('inspector-status-update');
    // });
    Route::controller(UserController::class)->group(function () {
        // Route::get('/view-inspector','index')->name('admin.view.inspector');
        Route::post('/usertableedetails', 'display')->name('usertableedetails');
        // Route::get('/update-inspector','update')->name('admin.show.inspector');
        // Route::post('submit/update-inspector/','submitUpdate')->name('admin.update.inspector');
        // Route::get('/add-inspector','create')->name('admin.create.addinspector');
        // Route::post('/insert-inspector','store')->name('admin.insert.insertinspector');
        // Route::post('/inspector-delete','destroy')->name('inspector-delete');
        // Route::post('/inspector-status-update','status')->name('inspector-status-update');
    });
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/show', 'show')->name('profile.show');
        Route::post('/profile/update', 'update')->name('profile.update');
        Route::post('/profile/updatepass', 'updatepass')->name('profile.updatepass');
    });

    Route::controller(MessagesListController::class)->group(function () {
        //Agency all messages list routes
        Route::get('/agency-message', 'index')->name('admin.agency.message');
        Route::post('/agency-messagesdetails', 'agencyDisplay')->name('agency-messagesdetails');
        //Inspector all messages list routes
        Route::get('/inspector-message', 'inspectorView')->name('admin.inspector.message');
        Route::post('/inspector-messagesdetails', 'inspectorDisplay')->name('inspector-messagesdetails');
    });
    Route::controller(MessagesController::class)->group(function () {
        Route::get('/chatify/1', 'index')->name('chatify-index');
    });
    Route::controller(JobCalenderController::class)->group(function () {
        Route::get('/jobcalender/show', 'index')->name('job.show');
        Route::post('/jobcalender/admininspectorevents', 'adminevents')->name('admininspectorevents');
    });

    Route::controller(AgencyController::class)->group(function () {
        Route::get('/agency-create', 'index')->name('admin.agency.agency-register');
        Route::post('/agency-insert', 'store')->name('admin.agency.agency-insert');
        Route::get('/agency-view', 'show')->name('admin.agency.agency-view');
        Route::post('/agency-details', 'display')->name('admin.agency.agency-details');
        Route::get('/agency-update', 'update')->name('admin.agency.agency-show');
        Route::post('submit/update-agency', 'submitUpdate')->name('admin.agency.update-agency');
        Route::post('/agency-status-update', 'status')->name('agency-status-update');
        Route::post('/agency-delete', 'destroy')->name('admin.agency-delete');
        Route::get('agency/password/password-reset', 'passwordReset')->name('admin.agency.passwordReset');
        Route::post('agency/password/submit', 'updatepassword')->name('admin.agency.Updatepassword');
    });

    Route::controller(ProtalController::class)->group(function () {
        Route::get('/portalsetup/show', 'index')->name('admin.portal.setup');
        Route::get('/portalsetup/mail', 'index')->name('admin.portal.mail');
        Route::post('/portalsetup/update/website', 'update')->name('portal.update.website');
        Route::post('/portalsetup/update/mail', 'updatemail')->name('portal.update.mail');
    });

    Route::controller(AgencyApprovalController::class)->group(function () {

        // for Status List
        Route::get('/agency/agency-list', 'statusApproved')->name('admin.adminlist.view');
        Route::post('/agency/agency-list/details', 'statusUpadteList')->name('admin.list.details');
        Route::get('/agency/status-update', 'approvalUpdate')->name('admin.status-update');
        Route::post('/status/submit', 'approvalUpdateSubmit')->name('admin.approvalUpdateSubmit');
        Route::post('/agency/agency-approval/status/update', 'approvalStatusUpdate')->name('approvalStatusUpdate');
        Route::get('/agency/disapproved-list', 'disApprovedList')->name('admin.disapproved.view');
        Route::post('/agency/details', 'statusDisApprovedList')->name('admin.disapproved.details');
    });
});

Auth::routes(['verify' => true]);


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    if(Auth::user()->approved =="Pending" || Auth::user()->approved =="Disapproved")
    {
        Auth::logout();
    //    return view('admin.approval')->with("msg",Auth::user()->approved);
        return view('admin.agency.approval');
    }
    else{
        return redirect('/home');
    }

})->middleware(['auth', 'signed'])->name('verification.verify');




Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
