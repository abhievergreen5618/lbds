<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SendInvoice;
use App\Models\Inspectiontype;
use App\Models\User;
use App\Models\RequestModel;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Mail\Admin\Inspectorassign;
use App\Models\Options;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Mail\Admin\Report;
use App\Models\EmailModel;
use Exception;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Common\Mail\MailBoxController;
use App\Mail\Admin\RequestScheduled;
use App\Mail\Admin\RequestUnderreview;
use App\Mail\Admin\RequestCompleted;

//Cron part
use App\Mail\Admin\ReminderMail;

class RequestController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:request-list', ['only' => ['show', 'display','showcompanylist','displaycompanylist','showinspectorlist','displayinspectorlist']]);
        $this->middleware('permission:request-create', ['only' => ['create', 'index']]);
        $this->middleware('permission:request-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:request-delete', ['only' => ['destroy']]);
    }
    public function index(Options $option)
    {
        $invoicedata = SendInvoice::where("status", "active")->pluck("name", "id");
        if (!session()->has('taskid')) {
            $id = RequestModel::create(["agency_related_files" => []]);
            $id = $id['id'];
            session()->put('taskid', $id);
        } else {
            $id = session()->get('taskid');
            if (RequestModel::where(["id" => $id])->count() == 0)
            {
                $id = RequestModel::create(["agency_related_files" => []]);
                $id = $id['id'];
                session()->put('taskid', $id);
            }
        }
        $data = Inspectiontype::where("status", "active")->pluck("name", "id");
        $roleid = Role::where("name", Auth::user()->roles->pluck('name')[0])->first("id");
        // session()->forget('taskid');
        if (Auth::user()->hasRole("admin")) {
            $companydetails = User::role('company')->where(["status" => "active"])->pluck("company_name", "id");
            return view('common.createrequest')->with(["data" => $data, "roleid" => $roleid, "invoicedata" => $invoicedata, "companydetails" => $companydetails, "id" => $id, "option" => $option]);
        } else {
            return view('common.createrequest')->with(["data" => $data, "roleid" => $roleid, "invoicedata" => $invoicedata, "id" => $id, "option" => $option]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                "agency" => "required",
                // "inspectiontype" => "required",
                "applicantname" => "required",
                "applicantemail" => "required",
                "applicantmobile" => "required",
                "address" => "required",
                "city" => "required",
                "state" => "required",
                "zipcode" => "required",
                "sendinvoice" => "required",
                // "comments" => "required",
            ],
            [
                "required" => "Field is required.",
            ]
        );
        if (isset($request['id'])) {
            $comment = isset($request['comments']) ? $request['comments'] : "";
            RequestModel::where("id", decrypt($request['id']))->update([
                "company_id" => decrypt($request['agency']),
                "inspectiontype" => $request['inspectiontype'],
                "applicantname" => $request['applicantname'],
                "applicantemail" => $request['applicantemail'],
                "applicantmobile" => $request['applicantmobile'],
                "address" => $request['address'],
                "city" => $request['city'],
                "state" => $request['state'],
                "zipcode" => $request['zipcode'],
                "sendinvoice" => $request['sendinvoice'],
                "comments" => $comment,
            ]);
            session()->forget('taskid');
        }
        $msg = "Details Saved Successfully";
        $newlocation = (Auth::user()->hasRole("admin")) ?  route('admin.request.list') : route('company.request.list');
        return response()->json(['msg' => $msg, 'newlocation' => $newlocation], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('admin.request.allrequest');
    }
    public function showinspectorlist(Request $request)
    {
        return view('inspector.request.requestlist');
    }

    public function assign(Request $request)
    {
        // $request['id'] = "eyJpdiI6IjhtM085TjU3akltRTl2YnpRNkZEeFE9PSIsInZhbHVlIjoicmhJc1hVTU4zNlFpeEdMM1kxR0tJdz09IiwibWFjIjoiMDkyYjc2ZTU0ZmE0ZmJkZjg4ZmQ3NTUyYWYwNTkwN2UxMjZkNWJlMmFjZTE0ZGM5ZTY4OWY3ZDM4YjQ3ZmQwYyIsInRhZyI6IiJ9";
        // $request['reqid'] = "eyJpdiI6IjhSU0pxNjZLaUV4UTdVRGJTNkdPdkE9PSIsInZhbHVlIjoiYlFTdEFCT2lxd3RyWFk0N1BvRHJsdz09IiwibWFjIjoiNDIyMjQ4Mjc1M2QwNWYyZTA2YWMzOGNmMWEzNDU4OWI1Zjc1ZGViNzg0NGQ3MTEzYWNlZmZkODQxMDU2Yzg3MSIsInRhZyI6IiJ9";
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "id" => 'required',
                "reqid" => 'required',
            ]);
            if ($validator->fails()) {
                $msg = "OOps! Something Went Wrong";
                return response()->json(array("msg" => $msg), 422);
            } else {
                $this->assign_ins($request['id'], $request['reqid']);
                $msg = "Inspector Assigned Successfully";
                return response()->json(array("msg" => $msg), 200);
            }
        } else {
            $request->validate(
                [
                    "id" => "required",
                    "reqid" => "required",
                ],
                [
                    "required" => "Field is required.",
                ]
            );
            $this->assign_ins($request['id'], $request['reqid']);
            $msg = "Inspector Assigned Successfully";
            return redirect()->back()->with('msg', $msg);
        }
    }


    public function assign_ins($id, $reqid)
    {
        $insemail = User::role('inspector')->where("id", decrypt($id))->first('email');
        $insdetails = User::role('inspector')->where("id", decrypt($id))->first();
        $requestdetails = RequestModel::where("id", decrypt($reqid))->first();
        $companydetails = User::role('company')->where("id", $requestdetails['company_id'])->first();
        // return view('admin.inspector.mail.assign')->with([
        //     'insdetails' => $insdetails,
        //     'requestdetails' => $requestdetails,
        //     'companydetails' => $companydetails,
        // ]);
        $subject = "Inspectorassign";
        if (!empty($companydetails->notification_settings) && (array_key_exists('request_assigned', $companydetails->notification_settings))) {
            Mail::to($companydetails['email'])->cc($requestdetails['applicantemail'])->send(new Inspectorassign($insdetails, $companydetails, $requestdetails, $subject,'companyassign'));
        }
        if (!empty($insdetails->notification_settings) && (array_key_exists('request_assigned', $insdetails->notification_settings))) {
            Mail::to($insemail['email'])->send(new Inspectorassign($insdetails, $companydetails, $requestdetails, $subject,'inspectorassign'));
        }
        $current_date_time = Carbon::now()->toDateTimeString();
        RequestModel::where(["id" => decrypt($reqid)])->update([
            "assigned_ins" => decrypt($id),
            "assigned_at" => $current_date_time,
            // "scheduled_at" => "",
            // "schedule_time" => "",
            "status" => "assigned",
        ]);
    }

    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $request->validate(
            [
                "id" => "required",
                "inspectiontype" => "required",
                "applicantname" => "required",
                "applicantemail" => "required",
                "applicantmobile" => "required",
                "address" => "required",
                "city" => "required",
                "state" => "required",
                "zipcode" => "required",
                "sendinvoice" => "required",
                // "comments" => "required",
            ],
            [
                "required" => "Field is required.",
            ]
        );
        RequestModel::where("id", decrypt($request['id']))->update([
            "inspectiontype" => $request['inspectiontype'],
            "applicantname" => $request['applicantname'],
            "applicantemail" => $request['applicantemail'],
            "applicantmobile" => $request['applicantmobile'],
            "address" => $request['address'],
            "city" => $request['city'],
            "state" => $request['state'],
            "zipcode" => $request['zipcode'],
            "sendinvoice" => $request['sendinvoice'],
            "comments" => $request['comments'],
            "ins_fee" => $request['ins_fee'],
            "requestnote" => $request['requestnote'],
            "inspectorcomments" => $request['inspectorcomments'],
        ]);
        return redirect()->back()->with('msg', 'Request Updated Successfully');
    }

    public function display(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = RequestModel::whereNotNull("company_id", "")->latest('id')->get(["id", "company_id", "applicantname", "address", "inspectiontype", "created_at", "status", "assigned_ins","invoice"]);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('company_id', function ($row) {
                    $company_name = User::role('company')->where(["id" => $row->company_id])->first("company_name");
                    return (!empty($company_name['company_name'])) ? $company_name['company_name'] : "";
                })
                ->addColumn('inspectiontype', function ($row) {
                    $returnvalue = "";
                    if (!empty($row->inspectiontype)) {
                        foreach ($row->inspectiontype as $value) {
                            $inspectiontype = Inspectiontype::where(["id" => $value])->first("name");
                            $returnvalue = $returnvalue . $inspectiontype['name'] . "<br>";
                        }
                    } else {
                        $returnvalue = "Inspection Type Not Applicable";
                    }
                    return $returnvalue;
                })
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $editlink = route('requestcheck', ['id' => $id]);
                    $deletebtn = (($row->status == "cancelled") ? "<a href='javascript:void(0)' data-id='$id' class='ml-2 delete btn red-btn btn-danger'  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'>Delete</a>" : (($row->status != "completed") ? "<a href='javascript:void(0)' data-id='$id' class='ml-2 cancel btn red-btn btn-warning'  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'>Cancel</a>" : ""));
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'>View</a>" . $deletebtn . "</div>";
                    return $btn;
                })
                ->addColumn('assigned_inspector', function ($row) {
                    $returnvalue = "<select class='form-control inspectorlist'  name='inspectorlist'><option value=''></option>";
                    $inspectors = User::role('inspector')->where('status','active')->pluck("name", "id");
                    foreach ($inspectors as $key => $value) {
                        $select = ((!empty($row->assigned_ins)) && $row->assigned_ins == $key) ? "selected" : "";
                        $returnvalue = $returnvalue . "<option value='" . encrypt($key) . "' data-req-id='" . encrypt($row->id) . "' $select>" . $value . "</option>";
                    }
                    $returnvalue = $returnvalue . "</select>";
                    return $returnvalue;
                })
                ->addColumn('created_at', function ($row) {
                    return date('F d ,Y h:i a',strtotime($row->created_at));
                })
                ->addColumn('invoice', function ($row) {
                    $checkstatus = (!empty($row->invoice) && $row->invoice == "active") ? "checked" :"" ;
                    return '<input type="checkbox" name="requestinvoice" data-bootstrap-switch="" data-off-color="danger" data-req-id="'.encrypt($row->id).'" data-on-color="success" value="yes" '.$checkstatus.'>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "pending" || $row->status == "underreview") {
                        $class = "badge btn-warning ml-2 status";
                    } elseif ($row->status == "scheduled" || $row->status == "cancelled" || $row->status == "assigned") {
                        $class = "badge btn-danger ml-2 status";
                    } elseif ($row->status == "completed") {
                        $class = "badge btn-success ml-2 status";
                    }
                    $btntext = ucfirst($row->status);
                    $id = encrypt($row->id);
                    // $markcompleted = ($row->status == "underreview") ? "<a href='javascript:void(0)' data-id='$id' class='ml-2 d-flex complete btn align-items-center btn-success'  data-bs-toggle='tooltip' data-bs-placement='top' title='Complete'><i class='fas fa-check-double fa-sm'></i><span class='ml-1'>Mark Completed</span></a>" : "";
                    // $statusBtn = "<div class='d-flex justify-content-center align-items-center'><a href='javascript:void(0)' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Task $btntext' class='$class'>$btntext</a>" . $markcompleted . "</div>";
                    $arr = ["pending", "assigned", "scheduled", "underreview", "completed"];
                    $returnvalue = "<select class='form-control statusdropdown' name='status' data-req-id='" . encrypt($row->id) . "'><option value=''></option>";
                    foreach ($arr as $key => $value) {
                        $select = ((!empty($row->status)) && $row->status === $value) ? "selected" : "";
                        $returnvalue = $returnvalue . "<option value='" . $value . "' $select>" . $value . "</option>";
                    }
                    $returnvalue = $returnvalue . "</select>";
                    return $returnvalue;
                })
                ->rawColumns(['company_id', 'inspectiontype', 'created_at', 'action', 'status', 'assigned_inspector','invoice'])
                ->make(true);
        }
    }
    public function displaycompanylist(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            if(Auth::user()->hasRole('employee'))
            {
                $userid = Auth::user()->company_id;
            }
            else
            {
                $userid = Auth::user()->id;
            }
            $data = RequestModel::where(["company_id" => $userid])->latest()->get(["id", "inspectiontype", "applicantname", "address", "city", "zipcode", "inspectiontype", "created_at", "status", "cancel_reason"]);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('inspectiontype', function ($row) {
                    $returnvalue = "";
                    if (!empty($row->inspectiontype)) {
                        foreach ($row->inspectiontype as $value) {
                            $inspectiontype = Inspectiontype::where(["id" => $value])->first("name");
                            $returnvalue = $returnvalue . $inspectiontype['name'] . "<br>";
                        }
                    } else {
                        $returnvalue = "Inspection Type Not Applicable";
                    }
                    return $returnvalue;
                })
                ->addColumn('created_at', function ($row) {
                    return date('F d ,Y h:i a',strtotime($row->created_at));
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "pending" || $row->status == "underreview") {
                        $class = "badge btn-warning ml-2 status";
                    } elseif ($row->status == "scheduled" || $row->status == "cancelled" || $row->status == "assigned") {
                        $class = "badge btn-danger ml-2 status";
                    } elseif ($row->status == "completed") {
                        $class = "badge btn-success ml-2 status";
                    }
                    $cancelreason = (!empty($row->status == "cancelled")) ? "<hr class='my-2'><span class='font-weight-600'>Reason</span><div>" . $row->cancel_reason . "</div>" : "";
                    $btntext = ucfirst($row->status);
                    $id = encrypt($row->id);
                    $statusBtn = "<div class='d-flex justify-content-center'><a href='javascript:void(0)' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Task $btntext' class='$class'>$btntext</a></div>" . $cancelreason;
                    return $statusBtn;
                })
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $editlink = route('requestcheck', ['id' => $id]);
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'>View</a></div>";
                    return $btn;
                })
                ->rawColumns(['action', 'inspectiontype', 'created_at', 'status'])
                ->make(true);
        }
    }
    public function displayinspectorlist(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = RequestModel::where(["assigned_ins" => Auth::user()->id])->latest()->get(["id", "company_id", "applicantname", "applicantemail", "applicantmobile", "address", "city", "state", "zipcode", "inspectiontype", "created_at", "status", "scheduled_at", "schedule_time", "underreview_at", "completed_at"]);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('company_id', function ($row) {
                    $heading = ["companyname" => "<span class='font-weight-600'>Company Name</span>", "companyphone" => "<span class='font-weight-600'>Company Phone</span>", "agentname" => "<span class='font-weight-600'>Agent Name</span>"];
                    $company_name = User::role('company')->where(["id" => $row->company_id])->first(["company_name", "company_phonenumber"]);
                    $companyname = (!empty($company_name['company_name'])) ?  $heading['companyname'] . "<div>" . $company_name['company_name'] . "</div>" : "";
                    $company_phone = (!empty($company_name['company_phonenumber'])) ?  $heading['companyphone'] . "<div>" . $company_name['company_phonenumber'] . "</div>" : "";
                    return $companyname . "<hr class='my-2'>" . $company_phone . "<hr class='my-2'>" . $heading['agentname'];
                })
                ->addColumn('applicantinformation', function ($row) {
                    $heading = ["name" => "<span class='font-weight-600'>Name</span>", "email" => "<span class='font-weight-600'>Email Address</span>", "phone" => "<span class='font-weight-600'>Phone</span>"];
                    $returnvalue = $heading['name'] . "<div>" . $row->applicantname . "</div><hr class='my-2'>" . $heading['email'] . "<div>" . $row->applicantemail . "</div><hr class='my-2'>" . $heading['phone'] . "<div>" . $row->applicantmobile . "</div>";
                    return $returnvalue;
                })
                ->addColumn('detailedaddress', function ($row) {
                    $heading = ["city" => "<span class='font-weight-600'>City</span>", "state" => "<span class='font-weight-600'>State</span>", "zipcode" => "<span class='font-weight-600'>Zip Code</span>"];
                    $returnvalue = $heading['city'] . "<div>" . $row->city . "</div><hr class='my-2'>" . $heading['state'] . "<div>" . $row->state . "</div><hr class='my-2'>" . $heading['zipcode'] . "<div>" . $row->zipcode . "</div>";
                    return $returnvalue;
                })
                ->addColumn('address', function ($row) {
                    $returnvalue = "<span class='font-weight-600'>Address</span><div>" . $row->address . "<div>";
                    return $returnvalue;
                })
                ->addColumn('otherinfo', function ($row) {
                    $heading = ["inspection" => "<span class='font-weight-600'>Inspection Type</span>", "created" => "<span class='font-weight-600'>Added At</span>"];
                    $created_at = date('F d ,Y h:i a', strtotime($row->created_at));
                    $inpectionlist = "<ul>";
                    foreach ($row->inspectiontype as $value) {
                        $inspectiontype = Inspectiontype::where(["id" => $value])->first("name");
                        $inpectionlist = $inpectionlist . "<li>" . $inspectiontype['name'] . "</li>";
                    }
                    $inpectionlist = $inpectionlist . "</ul>";
                    $returnvalue = $heading['inspection'] . "<div>" . $inpectionlist . "</div><hr class='my-2'>" . $heading['created'] . "<div>" . $created_at . "</div>";
                    return $returnvalue;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "pending" || $row->status == "underreview") {
                        $class = "btn btn-warning ml-2 status";
                    } elseif ($row->status == "scheduled" || $row->status == "cancelled" || $row->status == "assigned") {
                        $class = "btn btn-danger ml-2 status";
                    } elseif ($row->status == "completed") {
                        $class = "btn btn-success ml-2 status";
                    }
                    $btntext = ucfirst($row->status);
                    $id = encrypt($row->id);
                    $statusBtn = "<div class='d-flex justify-content-center'><a href='javascript:void(0)' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Task $btntext' class='$class'>$btntext</a></div>";
                    return $statusBtn;
                })
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $editlink = route('requestcheck', ['id' => $id]);
                    $time = (!empty($row->scheduled_at && $row->schedule_time)) ? $row->schedule_time   : "";
                    $date = (!empty($row->scheduled_at && $row->schedule_time)) ?  $row->scheduled_at : "";
                    $link = (!empty($row->scheduled_at && $row->schedule_time)) ? "https://calendar.google.com/calendar/r/eventedit?text=Inspection&details=test&location=&dates=" . $row->scheduled_at . "T" . $row->schedule_time . "ctz=(GMT+5:30)" : "#";
                    $schedule = (!empty($row->scheduled_at && $row->schedule_time)) ? "<hr class='my-2'><span class='font-weight-600'>Scheduled For</span><div class='scheduledhistoryae9e83'><div class='font-weight-500'><i class='far fa-clock fa-sm pr-1'></i>" . date('F d ,Y h:i a', strtotime($row->scheduled_at . $row->schedule_time)) : "";
                    if ($row->status == "scheduled") {
                        $btn = "<div class='d-flex justify-content-around'><a href='javascript:void(0)' data-id='$id' data-time='$time' data-date='$date' class='ml-2 reschedule btn red-btn btn-danger'  data-bs-toggle='tooltip' data-bs-placement='top' title='Reschedule'>Reschedule</a><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit ml-2'>View</a><a href='$link' data-id='$id' target='blank' class='d-flex align-items-center ml-2  btn red-btn btn-warning'  data-bs-toggle='tooltip' data-bs-placement='top' title='Calendar'><i class='fas fa-calendar'></i><span class='ml-2'>Calendar<span></a></div>" . $schedule . "</div></div><div class='mt-2 formsae9e83'><div class='mt-2'><button id='ae9e83' data-id='$id' class='btn btn-sm btn-success col-12 shadow-sm font-weight-500 pointer btn-submit-review submitreview'>Submit for Review <i class='fas fa-check-double fa-sm'></i></button></div></div>";
                    }
                    if ($row->status == "underreview") {
                        $schedulestatus = "<div class='d-flex justify-content-around'><span class='btn btn-sm btn-warning text-black font-weight-500 py-0'>Submitted for Review</span><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit ml-2'>View</a></div>";
                        $review = "<span class='font-weight-600'>Submitted for Review at</span><div>" . date('F d ,Y h:i a', strtotime($row->underreview_at)) . "</div>";
                        $btn = $schedulestatus . "<hr class='my-2'><div>" . $schedule . "</div><hr class='my-2'><div>" . $review . "</div>";
                    } else if ($row->status == "assigned") {
                        $btn = "<div class='d-flex justify-content-around'><a href='javascript:void(0)' data-id='$id' data-time='$time' data-date='$date' class='ml-2 schedule btn red-btn btn-danger'  data-bs-toggle='tooltip' data-bs-placement='top' title='Schedule'>Schedule</a><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit ml-2'>View</a></div>";
                    } else if ($row->status == "completed") {
                        $schedulestatus = "<div class='d-flex justify-content-around'><span class='btn btn-sm btn-warning text-black font-weight-500 py-0'>Completed</span><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit ml-2'>View</a></div>";
                        $review = "<span class='font-weight-600'>Completed At</span><div>" . date('F d ,Y h:i a', strtotime($row->completed_at)) . "</div>";
                        $btn = $schedulestatus . "<hr class='my-2'><div>" . $schedule . "</div><hr class='my-2'><div>" . $review . "</div>";
                    }
                    return $btn;
                })
                ->rawColumns(['company_id', 'applicantinformation', 'detailedaddress', 'address', 'otherinfo', 'status', 'action'])
                ->make(true);
        }
    }

    public function upload(Request $request)
    {
        if ($request->file('file')) {
            // $request->validate([
            //     'file.*' => 'required|mimes:image/jpeg,image/png,image/jpg,application/pdf|max:2048',
            // ]);
            if(isset($request['taskid'])) {
                $id = decrypt($request['taskid']);
                $type = ($request['type'] == "agencyfiles") ? "agency_related_files" : "reports_related_files";
                $files = RequestModel::where('id', $id)->first($type);
                $filearray = (!empty($files[$type]) && count($files[$type]) != 0) ? $files[$type] : array();
                foreach ($request->file('file') as $key => $value) {
                    $file = $value->getClientOriginalName();
                    $filename = pathinfo($file, PATHINFO_FILENAME);
                    $rand = rand(10, 5000);
                    $fileName = $filename."_".time() . $rand . '.' . $value->getClientOriginalExtension();
                    $value->move(public_path('taskfiles'), $fileName);
                    array_push($filearray, $fileName);
                }
                ($request['type'] == "agencyfiles") ? RequestModel::where('id', $id)->update(["agency_related_files" => $filearray]) : RequestModel::where('id', $id)->update(["reports_related_files" => $filearray]);
                return response()->json(array("msg" => "Added Successfully"), 200);
            }
            else if(session()->has('taskid')) {
                $id = $request->session()->get('taskid');
                $filearray = array();
                foreach ($request->file('file') as $key => $value) {
                    $file = $value->getClientOriginalName();
                    $filename = pathinfo($file, PATHINFO_FILENAME);
                    $rand = rand(10, 5000);
                    $fileName = $filename."_".time() . $rand . '.' . $value->getClientOriginalExtension();
                    $value->move(public_path('taskfiles'), $fileName);
                    array_push($filearray, $fileName);
                }
                ($request['type'] == "agencyfiles") ? RequestModel::where('id', $id)->update(["agency_related_files" => $filearray]) : RequestModel::where('id', $id)->update(["reports_related_files" => $filearray]);
                return response()->json(array("msg" => "Added Successfully"), 200);
            }
        }
    }
    public function requestcheck(Request $request,MailBoxController $mailhelper)
    {
        if(isset($_REQUEST['id']))
        {
            $data = $request->all();
            $data['id'] = decrypt($data['id']);
            $validator = Validator::make($data,
            [
                'id' => [
                    'required',
                    'exists:request_models,id',
                ],
            ]);
        }
        else
        {
            return redirect()->route('home')->with('error', '!Oops Something Went Wrong');
        }
        if ($validator->fails()) {
            return redirect()->route('home')->with('error', '!Oops Request Details Not Found');
        } else {
            $company = RequestModel::where("id", decrypt($request->id))->first('company_id');
            $companydetails = User::where("id", $company['company_id'])->first();
            $requestdetails = RequestModel::where("id", decrypt($request->id))->first();
            $maildraft = EmailModel::where(["requestid" => decrypt($request->id), "status" => "draft"])->first();
            $inspectordetails = User::where("id", $requestdetails['assigned_ins'])->first();
            $agencyfiles = RequestModel::where("id", decrypt($request->id))->first("agency_related_files");
            $reportfiles = RequestModel::where("id", decrypt($request->id))->first("reports_related_files");
            $data = Inspectiontype::where("status", "active")->pluck("name", "id");
            $invoicedata = SendInvoice::where("status", "active")->pluck("name", "id");
            $inslist = User::role('inspector')->pluck("name", "id");
            $maillist = [$requestdetails['applicantemail'], $companydetails['email']];
            if (!empty($maildraft['mailto']) && count($maildraft['mailto']) != 0) {
                $result = array_diff($maildraft['mailto'], $maillist);
                $maillist = (!empty($result) && count($result) != 0) ? array_merge($maillist, $result) : $maillist;
            }
            $attachments = $this->get_merged_files($agencyfiles['agency_related_files'], $reportfiles['reports_related_files']);
            return view('admin.request.requeststatus')->with(
                [
                    "companydetails" => $companydetails,
                    "requestdetails" => $requestdetails,
                    "agencyfiles" => $agencyfiles['agency_related_files'],
                    "reportfiles" => $reportfiles['reports_related_files'],
                    "invoicedata" => $invoicedata,
                    "inspectordetails" => $inspectordetails,
                    "data" => $data,
                    "inslist" => $inslist,
                    "maillist" => $maillist,
                    "attachments" => $attachments,
                    "maildraft" => $maildraft,
                    "mailhelper" => $mailhelper,
                ]
            );
        }
    }

    public function get_merged_files($agencyfiles, $reportfiles)
    {
        if ($agencyfiles != NULL && $reportfiles != NULL) {
            return array_merge($agencyfiles, $reportfiles);
        } elseif ($agencyfiles == NULL) {
            return $reportfiles;
        } elseif ($reportfiles == NULL) {
            return $agencyfiles;
        } else {
            return array();
        }
    }

    public function filedownload(Request $request)
    {
        $request->validate([
            "filename" => "required",
        ]);
        $file = public_path('taskfiles') . "/" . $request['filename'];
        return response()->download($file);
    }


    public function destroy(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        RequestModel::where('id', decrypt($request['id']))->delete();
        $msg = "Deleted Successfully";
        return response()->json(array("msg" => $msg), 200);
    }

    public function schedule(Request $request)
    {
        $request->validate(
            [
                "id"   => "required",
                "time" => "required",
                "date" => "required|date|after:yesterday",
            ],
            [
                "required" => "Field is required.",
            ]
        );
        $this->send_email($request['id'], "scheduled");
        RequestModel::where('id', decrypt($request['id']))->update([
            "status" => "scheduled",
            "scheduled_at" => $request->date,
            "schedule_time" => $request->time,
        ]);
        return redirect()->back()->with('msg', 'Request Scheduled Successfully');
    }

    // request reschedule by inspector
    public function reschedule(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "id" => 'required',
                "date" => 'required',
                "time" => 'required',
                "status" => 'required',
            ]);
            if ($validator->fails()) {
                $msg = "OOps! Something Went Wrong";
                return response()->json(array("msg" => $msg), 422);
            } else {
                $this->send_email($request['id'], "scheduled");
                RequestModel::where('id', decrypt($request['id']))->update([
                    "status" => "scheduled",
                    "scheduled_at" => $request->date,
                    "schedule_time" => $request->time,
                    "remindermailstatus" => "notsend",
                ]);
                $msg = "Request " . $request['status'] . " Successfully";
                return response()->json(array("msg" => $msg), 200);
            }
        }
    }

    // request review submit by inspector
    public function submitreview(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "id" => 'required',
            ]);
            if ($validator->fails()) {
                $msg = "OOps! Something Went Wrong";
                return response()->json(array("msg" => $msg), 422);
            } else {
                $current_date_time = Carbon::now()->toDateTimeString();
                $this->send_email($request['id'], "underreview");
                RequestModel::where('id', decrypt($request['id']))->update([
                    "status" => "underreview",
                    "underreview_at" => $current_date_time,
                ]);
                $msg = "Review Submitted Successfully";
                return response()->json(array("msg" => $msg), 200);
            }
        }
    }

    // request cancel
    public function cancel(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        // $this->send_email($request['id'], "cancelled");
        RequestModel::where('id', decrypt($request['id']))->update([
            "status" => "cancelled",
            "cancel_reason" => $request['msg'],
        ]);
        $msg = "Request Cancelled Successfully";
        return response()->json(["msg" => $msg], 200);
    }


    // request complete
    public function statusupdate(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "id" => 'required',
                "status" => 'required',
            ]);
            if ($validator->fails()) {
                $msg = "OOps! Something Went Wrong";
                return response()->json(array("msg" => $msg), 422);
            } else {
                $current_date_time = Carbon::now()->toDateTimeString();
                // $this->send_email($request['id'], "completed");
                $status = $request['status'] . "_at";
                if ($request['status'] == "pending") {
                    RequestModel::where('id', decrypt($request['id']))->update([
                        "status" => $request['status'],
                        "assigned_at" => NULL,
                        "scheduled_at" => NULL,
                        "schedule_time" => NULL,
                        "underreview_at" => NULL,
                        "completed_at" => NULL,
                        "assigned_ins" => NULL,
                    ]);
                } elseif ($request['status'] == "assigned") {
                    RequestModel::where('id', decrypt($request['id']))->update([
                        "status" => $request['status'],
                        "schedule_time" => NULL,
                        "underreview_at" => NULL,
                        "completed_at" => NULL,
                        $status => $current_date_time,
                    ]);
                } elseif ($request['status'] == "scheduled") {
                    RequestModel::where('id', decrypt($request['id']))->update([
                        "status" => $request['status'],
                        $status => $current_date_time,
                    ]);
                } elseif ($request['status'] == "underreview") {
                    RequestModel::where('id', decrypt($request['id']))->update([
                        "status" => $request['status'],
                        "completed_at" => NULL,
                        $status => $current_date_time,
                    ]);
                } elseif ($request['status'] == "completed") {
                    RequestModel::where('id', decrypt($request['id']))->update([
                        "status" => $request['status'],
                        $status => $current_date_time,
                    ]);
                    $this->send_email($request['id'], "completed");
                }
                $msg = "Request Status Updated Successfully";
                return response()->json(array("msg" => $msg), 200);
            }
        }
    }

    public function send_email($id, $status)
    {
        // $data = RequestModel::leftJoin('users  AS inspector','inspector.id', '=', 'request_models.assigned_ins')
        // ->leftJoin('users AS company','company.id', '=', 'request_models.company_id')
        // ->where("request_models.id",decrypt($id))->get();
        $requestdetails = RequestModel::where("id", decrypt($id))->first();
        $insdetails = User::where("id", $requestdetails['assigned_ins'])->first();
        $companydetails = User::where("id", $requestdetails['company_id'])->first();
        $requestdetails = RequestModel::where("id", decrypt($id))->first();
        $insdetails = User::where("id", $requestdetails['assigned_ins'])->first();
        $companydetails = User::where("id", $requestdetails['company_id'])->first();

        if ($status == "scheduled") {
            $subject = "Request Scheduled";

            if (!empty($companydetails->notification_settings) && (array_key_exists('request_scheduled', $companydetails->notification_settings))) {
                Mail::to($companydetails['email'])->cc($requestdetails['applicantemail'])->send(new RequestScheduled($insdetails, $companydetails, $requestdetails, $subject,'companyassign'));
            }
            if (!empty($insdetails->notification_settings) && (array_key_exists('request_scheduled', $insdetails->notification_settings))) {
                Mail::to($insdetails['email'])->send(new RequestScheduled($insdetails, $companydetails, $requestdetails, $subject,'inspectorassign'));
            }
        } else if ($status == "rescheduled") {
            $subject = "Request Rescheduled";
        } else if ($status == "cancelled") {
            $subject = "Request Cancelled";

            Mail::to($insdetails['email'])->send(new RequestScheduled($insdetails, $companydetails, $requestdetails, $subject,'companyassign'));
            Mail::to($companydetails['email'])->cc($requestdetails['applicantemail'])->send(new RequestScheduled($insdetails, $companydetails, $requestdetails, $subject,'inspectorassign'));
        } else if ($status == "underreview") {
            $subject = "Request Underreview";

            if (!empty($companydetails->notification_settings) && (array_key_exists('request_underreview', $companydetails->notification_settings))) {
                Mail::to($companydetails['email'])->cc($requestdetails['applicantemail'])->send(new RequestUnderreview($insdetails, $companydetails, $requestdetails, $subject,'companyassign'));
            }
            if (!empty($insdetails->notification_settings) && (array_key_exists('request_underreview', $insdetails->notification_settings))) {
                Mail::to($insdetails['email'])->send(new RequestUnderreview($insdetails, $companydetails, $requestdetails, $subject,'inspectorassign'));
            }
        } else if ($status == "completed") {
            $subject = "Request Completed";

            if (!empty($companydetails->notification_settings) && (array_key_exists('request_completed', $companydetails->notification_settings))) {
                Mail::to($companydetails['email'])->cc($requestdetails['applicantemail'])->send(new RequestCompleted($insdetails, $companydetails, $requestdetails, $subject,'companyassign'));
            }
            if (!empty($insdetails->notification_settings) && (array_key_exists('request_completed', $insdetails->notification_settings))) {
                Mail::to($insdetails['email'])->send(new RequestCompleted($insdetails, $companydetails, $requestdetails, $subject,'inspectorassign'));
            }
        }

        // if(!empty($insdetails))
        // {
        //     Mail::to($insdetails['email'])->send(new Inspectorassign($insdetails, $companydetails, $requestdetails, $subject));
        //     Mail::to($companydetails['email'])->cc($requestdetails['applicantemail'])->send(new Inspectorassign($insdetails,$companydetails, $requestdetails, $subject));
        // }
        //end
    }


    public function showcompanylist(Request $request)
    {
        return view('company.request.requestlist');
    }
    public function sendmailreport(Request $request, EmailModel $reportemail)
    {
        $data = $request->all();
        $request->validate(
            [
                "reportmailto" => "required_if:btn,send",
                "subject" => "required_if:btn,send",
                "message" => "required_if:btn,send",
            ],
            [
                "required_if" => "This field is required.",
            ]
        );
        $data['requestid'] = decrypt($data['requestid']);
        if ($request['btn'] == "send") {
            try {
                Mail::to($request['reportmailto'])->cc($request['reportmailcc'])->bcc($request['reportmailbcc'])->send(new Report($data));
                // // check for failures
                // if (Mail::failures()) {
                //     $returnmessage = "There was one or more failures. They were: <br />";
                //     foreach(Mail::failures() as $email_address) {
                //         $returnmessage = $returnmessage." - $email_address <br />";
                //      }
                //     return redirect()->back()->with('error',$returnmessage);
                //     // return response showing failed emails
                // }
                $reportemail->saveemail($data, "sent");
            } catch (Exception $e) {
                dd($e->getMessage());
                $reportemail->saveemaildraft($data, "draft");
                return redirect()->back()->with('error', 'Failed To Send Report Mail');
            }
            return redirect()->back()->with('msg', 'Report Mail Send Successfully');
        }
        else
        {
            $data['reportmailto'] = isset($data['reportmailto']) ? $data['reportmailto'] : NULL;
            $reportemail->saveemaildraft($data, "draft");
            return redirect()->back()->with('msg', 'Report Draft Saved Successfully');
        }
    }
    public function invoicestatusupdate(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
                "state" => 'required',
            ]
        );
        $status = ($request['state'] == "true") ? "active" : "inactive";
        RequestModel::where('id', decrypt($request['id']))->update([
            "invoice" => $status,
        ]);
        $msg = ($status == "active") ? "Invoice Activated Successfully" :"Invoice Inactivated Successfully";
        return response()->json(["msg" => $msg], 200);
    }
}
