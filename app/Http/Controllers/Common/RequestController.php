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
        $data = Inspectiontype::where("status", "active")->pluck("name","id");
        $invoicedata = SendInvoice::where("status", "active")->pluck("name","id");
        if(!session()->has('taskid'))
        {
            $id = RequestModel::create(["agency_related_files" =>[]]);
            $id = $id['id'];
            session()->put('taskid',$id);
        }
        else
        {
            $id = session()->get('taskid');
        }
        // session()->forget('taskid');
        if (Auth::user()->hasRole("admin")) {
            $companydetails = User::role('company')->where(["status" => "active"])->pluck("company_name", "id");
            return view('common.createrequest')->with(["data" => $data, "invoicedata" => $invoicedata, "companydetails" => $companydetails,"id"=> $id]);
        } else {
            return view('common.createrequest')->with(["data" => $data, "invoicedata" => $invoicedata,"id"=> $id]);
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
        return response()->json(array("msg" => $msg), 200);
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

    public function assign(Request $request)
    {
        // $request['id'] = "eyJpdiI6IjhtM085TjU3akltRTl2YnpRNkZEeFE9PSIsInZhbHVlIjoicmhJc1hVTU4zNlFpeEdMM1kxR0tJdz09IiwibWFjIjoiMDkyYjc2ZTU0ZmE0ZmJkZjg4ZmQ3NTUyYWYwNTkwN2UxMjZkNWJlMmFjZTE0ZGM5ZTY4OWY3ZDM4YjQ3ZmQwYyIsInRhZyI6IiJ9";
        // $request['reqid'] = "eyJpdiI6IjhSU0pxNjZLaUV4UTdVRGJTNkdPdkE9PSIsInZhbHVlIjoiYlFTdEFCT2lxd3RyWFk0N1BvRHJsdz09IiwibWFjIjoiNDIyMjQ4Mjc1M2QwNWYyZTA2YWMzOGNmMWEzNDU4OWI1Zjc1ZGViNzg0NGQ3MTEzYWNlZmZkODQxMDU2Yzg3MSIsInRhZyI6IiJ9";
        $validator = Validator::make($request->all(), [
            "id" => 'required',
            "reqid" => 'required',
        ]);
        if ($validator->fails()) {
            $msg = "OOps! Something Went Wrong";
            return response()->json(array("msg" => $msg), 422);
        } else {
            $insemail = User::role('inspector')->where("id",decrypt($request['id']))->first('email');
            $insdetails = User::role('inspector')->where("id",decrypt($request['id']))->first();
            $requestdetails = RequestModel::where("id",decrypt($request['reqid']))->first();
            $companydetails = User::role('company')->where("id",$requestdetails['company_id'])->first();
            // return view('admin.inspector.mail.assign')->with([
            //     'insdetails' => $insdetails,
            //     'requestdetails' => $requestdetails,
            //     'companydetails' => $companydetails,
            // ]);  
            Mail::to($insemail['email'])->send(new Inspectorassign($insdetails,$companydetails,$requestdetails));
            Mail::to($requestdetails['applicantemail'])->send(new Inspectorassign($insdetails,$companydetails,$requestdetails));
            $current_date_time = Carbon::now()->toDateTimeString();
            RequestModel::where(["id" => decrypt($request['reqid'])])->update([
                "assigned_ins" => decrypt($request['id']),
                "assigned_at" => $current_date_time,
                "status" => "scheduled",
            ]);
            $msg = "Inspector Assigned Successfully";
            return response()->json(array("msg" => $msg), 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        return redirect()->back()->with('msg','Request Updated Successfully');
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
            "schedule_at" => $request->date,
            "schedule_time" => $request->time,
        ]);
        return redirect()->back()->with('msg','Request Scheduled Successfully');
    }


    public function display(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = RequestModel::whereNotNull("company_id","")->latest()->get(["id", "company_id", "applicantname", "address", "inspectiontype", "created_at", "status", "assigned_ins"]);
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
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'>View</a><a href='javascript:void(0)' data-id='$id' class='ml-2 delete btn red-btn btn-warning'  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'>Cancel</a><a href='javascript:void(0)' data-id='$id' class='ml-2 delete btn red-btn btn-danger'  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'>Delete</a></div>";
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
                    if ($row->status == "pending") {
                        $class = "btn btn-warning ms-2 status";
                    } elseif ($row->status == "scheduled") {
                        $class = "btn btn-danger ms-2 status";
                    } elseif ($row->status == "completed") {
                        $class = "btn btn-success ms-2 status";
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

    public function upload(Request $request)
    {
        if ($request->file('file')) {
            // $request->validate([
            //     'file.*' => 'required|mimes:image/jpeg,image/png,image/jpg,application/pdf|max:2048',
            // ]);
            if (session()->has('taskid')) {
                $id = $request->session()->get('taskid');
                $filearray = array();
                foreach($request->file('file') as $key=>$value)
                {
                    $rand = rand(10, 5000);
                    $fileName = time() . $rand . '.' .$value->getClientOriginalExtension();
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
        $requestdetails = RequestModel::where("id",decrypt($request->id))->first();
        $inspectordetails = User::where("id",$requestdetails['assigned_ins'])->first();
        $agencyfiles = RequestModel::where("id", decrypt($request->id))->first("agency_related_files");
        $reportfiles = RequestModel::where("id", decrypt($request->id))->first("reports_related_files");
        $data = Inspectiontype::where("status", "active")->pluck("name", "id");
        $invoicedata = SendInvoice::where("status", "active")->pluck("name", "id");
        return view('admin.request.requeststatus')->with(
            [
                "companydetails" => $companydetails,
                "requestdetails" => $requestdetails,
                "agencyfiles" => $agencyfiles['agency_related_files'],
                "reportfiles" => $reportfiles['reports_related_files'],
                "invoicedata" => $invoicedata,
                "inspectordetails" => $inspectordetails,
                "data" => $data 
            ]
        );
    }
    public function filedownload(Request $request)
    {
        $request->validate([
            "filename" => "required",
        ]);
        $file = public_path('taskfiles')."/".$request['filename'];       
        return response()->download($file);
    }
}
