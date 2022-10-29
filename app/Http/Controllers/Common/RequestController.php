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
use Illuminate\Support\Facades\Mail;

class RequestController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:request-list|request-create|request-edit|request-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:request-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:request-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:request-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data = Inspectiontype::where("status", "active")->pluck("name", "id");
        $invoicedata = SendInvoice::where("status", "active")->pluck("name", "id");
        if (!session()->has('taskid')) {
            $id = RequestModel::create(["agency_related_files" => []]);
            $id = $id['id'];
            session()->put('taskid', $id);
        } else {
            $id = session()->get('taskid');
        }
        // session()->forget('taskid');
        if (Auth::user()->hasRole("admin")) {
            $companydetails = User::role('company')->where(["status" => "active"])->pluck("company_name", "id");
            return view('common.createrequest')->with(["data" => $data, "invoicedata" => $invoicedata, "companydetails" => $companydetails, "id" => $id]);
        } else {
            return view('common.createrequest')->with(["data" => $data, "invoicedata" => $invoicedata, "id" => $id]);
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
                "inspectiontype" => "required",
                "applicantname" => "required",
                "applicantemail" => "required",
                "applicantmobile" => "required",
                "address" => "required",
                "city" => "required",
                "state" => "required",
                "zipcode" => "required",
                "sendinvoice" => "required",
                "comments" => "required",
            ],
            [
                "required" => "Field is required.",
            ]
        );
        if (isset($request['id'])) {
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
                "comments" => $request['comments'],
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
        Mail::to($insemail['email'])->send(new Inspectorassign($insdetails, $companydetails, $requestdetails));
        Mail::to($requestdetails['applicantemail'])->send(new Inspectorassign($insdetails, $companydetails, $requestdetails));
        $current_date_time = Carbon::now()->toDateTimeString();
        RequestModel::where(["id" => decrypt($reqid)])->update([
            "assigned_ins" => decrypt($id),
            "assigned_at" => $current_date_time,
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
                "comments" => "required",
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
        ]);
        return redirect()->back()->with('msg', 'Request Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                "date" => "required|date|after:today",
            ],
            [
                "required" => "Field is required.",
            ]
        );
        RequestModel::where('id', decrypt($request['id']))->update([
            "status" => "scheduled",
            "schedule_at" => $request->date,
            "schedule_time" => $request->time,
        ]);
        return redirect()->back()->with('msg', 'Request Scheduled Successfully');
    }


    public function display(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = RequestModel::whereNotNull("company_id", "")->latest()->get(["id", "company_id", "applicantname", "address", "inspectiontype", "created_at", "status", "assigned_ins"]);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('company_id', function ($row) {
                    $company_name = User::role('company')->where(["id" => $row->company_id])->first("company_name");
                    return (!empty($company_name['company_name'])) ? $company_name['company_name'] : "";
                })
                ->addColumn('inspectiontype', function ($row) {
                    $returnvalue = "";
                    foreach ($row->inspectiontype as $value) {
                        $inspectiontype = Inspectiontype::where(["id" => $value])->first("name");
                        $returnvalue = $returnvalue . $inspectiontype['name'] . "<br>";
                    }
                    return $returnvalue;
                })
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $editlink = route('requestcheck', ['id' => $id]);
                    $deletebtn = ($row->status == "cancelled") ? "<a href='javascript:void(0)' data-id='$id' class='ml-2 delete btn red-btn btn-danger'  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'>Delete</a>" : "<a href='javascript:void(0)' data-id='$id' class='ml-2 cancel btn red-btn btn-warning'  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'>Cancel</a>";
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'>View</a>" . $deletebtn . "</div>";
                    return $btn;
                })
                ->addColumn('assigned_inspector', function ($row) {
                    $returnvalue = "<select class='form-control inspectorlist' name='inspector' id='inspector'><option value=''></option>";
                    $inspectors = User::role('inspector')->pluck("name", "id");
                    foreach ($inspectors as $key => $value) {
                        $select = ((!empty($row->assigned_ins)) && $row->assigned_ins == $key) ? "selected" : "";
                        $returnvalue = $returnvalue . "<option value='" . encrypt($key) . "' data-req-id='" . encrypt($row->id) . "' $select>" . $value . "</option>";
                    }
                    $returnvalue = $returnvalue . "</select>";
                    return $returnvalue;
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y h:i a', strtotime($row->created_at));
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "pending" || $row->status == "underreview") {
                        $class = "badge btn-warning ms-2 status";
                    } elseif ($row->status == "scheduled" || $row->status == "cancelled" || $row->status == "assigned") {
                        $class = "badge btn-danger ms-2 status";
                    } elseif ($row->status == "completed") {
                        $class = "badge btn-success ms-2 status";
                    }
                    $btntext = ucfirst($row->status);
                    $id = encrypt($row->id);
                    $statusBtn = "<div class='d-flex justify-content-center'><a href='javascript:void(0)' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Task $btntext' class='$class'>$btntext</a></div>";
                    return $statusBtn;
                })
                ->rawColumns(['company_id', 'inspectiontype', 'created_at', 'action', 'status', 'assigned_inspector'])
                ->make(true);
        }
    }
    public function displaycompanylist(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = RequestModel::where(["company_id" => Auth::user()->id])->latest()->get(["id", "inspectiontype", "applicantname", "address", "city", "zipcode", "inspectiontype", "created_at", "status","cancel_reason"]);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('inspectiontype', function ($row) {
                    $returnvalue = "";
                    foreach ($row->inspectiontype as $value) {
                        $inspectiontype = Inspectiontype::where(["id" => $value])->first("name");
                        $returnvalue = $returnvalue . $inspectiontype['name'] . "<br>";
                    }
                    return $returnvalue;
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y h:i a', strtotime($row->created_at));
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "pending" || $row->status == "underreview") {
                        $class = "badge btn-warning ms-2 status";
                    } elseif ($row->status == "scheduled" || $row->status == "cancelled" || $row->status == "assigned") {
                        $class = "badge btn-danger ms-2 status";
                    } elseif ($row->status == "completed") {
                        $class = "badge btn-success ms-2 status";
                    }
                    $cancelreason = (!empty($row->status == "cancelled")) ? "<hr class='my-2'><span class='font-weight-600'>Reason</span><div>".$row->cancel_reason."</div>" : "";
                    $btntext = ucfirst($row->status);
                    $id = encrypt($row->id);
                    $statusBtn = "<div class='d-flex justify-content-center'><a href='javascript:void(0)' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Task $btntext' class='$class'>$btntext</a></div>".$cancelreason;
                    return $statusBtn;
                })
                ->rawColumns(['inspectiontype', 'created_at', 'status'])
                ->make(true);
        }
    }
    public function displayinspectorlist(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = RequestModel::where(["assigned_ins" => Auth::user()->id])->latest()->get(["id","company_id", "applicantname", "applicantemail", "applicantmobile", "address", "city", "state", "zipcode", "inspectiontype", "created_at", "status", "schedule_at", "schedule_time","review_at"]);
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
                        $time = (!empty($row->schedule_at && $row->schedule_time)) ? $row->schedule_time   : "";
                        $date = (!empty($row->schedule_at && $row->schedule_time)) ?  $row->schedule_at : "";
                        $link = (!empty($row->schedule_at && $row->schedule_time)) ? "https://calendar.google.com/calendar/r/eventedit?text=Inspection&details=test&location=&dates=".$row->schedule_at."T".$row->schedule_time."ctz=(GMT+5:30)" : "#";
                        $schedule = (!empty($row->schedule_at && $row->schedule_time)) ? "<hr class='my-2'><span class='font-weight-600'>Scheduled For</span><div class='scheduledhistoryae9e83'><div class='font-weight-500'><i class='far fa-clock fa-sm pr-1'></i>" . date('F d ,Y h:i a', strtotime($row->schedule_at . $row->schedule_time)): "";
                    if($row->status == "scheduled")
                    {   
                        $btn = "<div class='d-flex justify-content-around'><a href='javascript:void(0)' data-id='$id' data-time='$time' data-date='$date' class='ml-2 reschedule btn red-btn btn-danger'  data-bs-toggle='tooltip' data-bs-placement='top' title='Reschedule'>Reschedule</a><a href='$link' data-id='$id' target='blank' class='d-flex align-items-center ml-2  btn red-btn btn-warning'  data-bs-toggle='tooltip' data-bs-placement='top' title='Calendar'><i class='fas fa-calendar'></i><span class='ml-2'>Calendar<span></a></div>".$schedule."</div></div><div class='mt-2 formsae9e83'><div class='mt-2'><button id='ae9e83' data-id='$id' class='btn btn-sm btn-success col-12 shadow-sm font-weight-500 pointer btn-submit-review submitreview'>Submit for Review <i class='fas fa-check-double fa-sm'></i></button></div></div>" ;
                    }
                    if($row->status == "underreview")
                    {
                        $schedulestatus = "<span class='btn btn-sm btn-warning text-black font-weight-500 py-0'>Submitted for Review</span>";
                        $review = "<span class='font-weight-600'>Submitted for Review at</span><div>". date('F d ,Y h:i a', strtotime($row->review_at))."</div>";
                        $btn = $schedulestatus."<hr class='my-2'><div>".$schedule."</div><hr class='my-2'><div>".$review."</div>";
                    }
                    else if($row->status == "assigned")
                    {
                        $btn = "<span>Soon it will be scheduled by admin.</span>";
                    }
                    else if($row->status == "completed")
                    {
                        $schedulestatus = "<span class='btn btn-sm btn-warning text-black font-weight-500 py-0'>Completed</span>";
                        $review = "<span class='font-weight-600'>Completed At</span><div>". date('F d ,Y h:i a', strtotime($row->completed_at))."</div>";
                        $btn = $schedulestatus."<hr class='my-2'><div>".$schedule."</div><hr class='my-2'><div>".$review."</div>";
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
            if (session()->has('taskid')) {
                $id = $request->session()->get('taskid');
                $filearray = array();
                foreach ($request->file('file') as $key => $value) {
                    $rand = rand(10, 5000);
                    $fileName = time() . $rand . '.' . $value->getClientOriginalExtension();
                    $value->move(public_path('taskfiles'), $fileName);
                    array_push($filearray, $fileName);
                }
                ($request['type'] == "agencyfiles") ? RequestModel::where('id', $id)->update(["agency_related_files" => $filearray]) : RequestModel::where('id', $id)->update(["reports_related_files" => $filearray]);
                return response()->json(array("msg" => "Added Successfully"), 200);
            }
        }
    }
    public function requestcheck(Request $request)
    {
        $company = RequestModel::where("id", decrypt($request->id))->first('company_id');
        $companydetails = User::where("id", $company['company_id'])->first();
        $requestdetails = RequestModel::where("id", decrypt($request->id))->first();
        $inspectordetails = User::where("id", $requestdetails['assigned_ins'])->first();
        $agencyfiles = RequestModel::where("id", decrypt($request->id))->first("agency_related_files");
        $reportfiles = RequestModel::where("id", decrypt($request->id))->first("reports_related_files");
        $data = Inspectiontype::where("status", "active")->pluck("name", "id");
        $invoicedata = SendInvoice::where("status", "active")->pluck("name", "id");
        $inslist = User::role('inspector')->pluck("name", "id");
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
            ]
        );
    }
    public function filedownload(Request $request)
    {
        $request->validate([
            "filename" => "required",
        ]);
        $file = public_path('taskfiles') . "/" . $request['filename'];
        return response()->download($file);
    }
    public function cancel(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        RequestModel::where('id', decrypt($request['id']))->update([
            "status" => "cancelled",
            "cancel_reason" => $request['msg'],
        ]);
        $msg = "Request Cancelled Successfully";
        return response()->json(["msg" => $msg], 200);
    }
    public function showcompanylist(Request $request)
    {
        return view('company.request.requestlist');
    }
    public function submitreview(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "id" => 'required',
            ]);
            if ($validator->fails()) {
                $msg = "OOps! Something Went Wrong";
                return response()->json(array("msg" => $msg), 422);
            } else {
                $current_date_time = Carbon::now()->toDateTimeString();
                RequestModel::where('id', decrypt($request['id']))->update([
                    "status" => "underreview",
                    "review_at" => $current_date_time,
                ]);
                $msg = "Review Submitted Successfully";
                return response()->json(array("msg" => $msg), 200);
            }
        }
    }
    public function reschedule(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "id" => 'required',
                "date" => 'required',
                "time" => 'required',
            ]);
            if ($validator->fails()) {
                $msg = "OOps! Something Went Wrong";
                return response()->json(array("msg" => $msg), 422);
            } else {
                RequestModel::where('id', decrypt($request['id']))->update([
                    "schedule_at" => $request->date,
                    "schedule_time" => $request->time,
                ]);
                $msg = "Request Rescheduled Successfully";
                return response()->json(array("msg" => $msg), 200);
            }
        }
    }
}
