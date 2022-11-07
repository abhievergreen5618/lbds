<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inspectiontype;
use DataTables;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Options;

class InspectionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:inspection-list', ['only' => ['show','display']]);
         $this->middleware('permission:inspection-create', ['only' => ['index','store']]);
         $this->middleware('permission:inspection-edit', ['only' => ['index','update']]);
         $this->middleware('permission:inspection-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        return view('admin.inspection.addinspectiontype');
    }

    public function create(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "description"=>"required",
            "status"=>"required",
        ]);
        if(isset($request['id']) && !empty($request['id']))
        {
            Inspectiontype::where('id',decrypt($request['id']))->update([
                "name" => $request->name,
                "description" => $request->description,
                "status" => $request->status,
            ]);
            return redirect()->route('admin.allinspectiontype')->with("msg","Record Updated Successfully");
        }
        else
        {
            Inspectiontype::create([
                "name" => $request->name,
                "description" => $request->description,
                "status" => $request->status,
            ]);
            return redirect()->route('admin.allinspectiontype')->with("msg","Record Created Successfully");
        }
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
    public function show(Options $option)
    {
        $roles = Role::orderBy('id','DESC')->pluck('name','id');
        $user = User::role('company')->orderBy('id','DESC')->pluck('name','id');
        $disableinspectionroles = $option->get_option("disableinspectionroles");
        $disableinspectionusers = $option->get_option("disableinspectionusers");
        return view('admin.inspection.allinspectiontype')->with([
            "roles" => $roles,
            "user" => $user,
            "disableinspectionroles" => $disableinspectionroles,
            "disableinspectionusers" => $disableinspectionusers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disableshow(Request $request,Options $option)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "id" => 'required',
                "show" => 'required',
            ]);
            if ($validator->fails()) {
                $msg = "OOps! Something Went Wrong";
                return response()->json(array("msg" => $msg), 422);
            } else {
                $option->updatedisableinspection($request['show'],decrypt($request['id']),$request['action']);
                $msg = "Inspection Type Disabled Successfully";
                return response()->json(array("msg" => $msg), 200);
            }
        }
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
        if(isset($request['id']) && !empty($request['id']))
        {   
            $data = Inspectiontype::where('id', decrypt($request['id']))->first();
            return view('admin.inspection.addinspectiontype')->with(["data"=>$data]);
        }
        else
        {
            return redirect()->back()->with("msg","Record Created Successfully");
        }
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
        Inspectiontype::where('id', decrypt($request['id']))->delete();
        $msg = "Deleted Successfully";
        return response()->json(array("msg" => $msg), 200);
    }


    public function status(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        $status = Inspectiontype::where('id', decrypt($request['id']))->first('status');
        $status= ($status['status'] == "active") ? "inactive" : "active";
        Inspectiontype::where('id', decrypt($request['id']))->Update([
            "status" => $status,
        ]);
        $msg = "Status Updated Successfully";
        return response()->json(array("msg" => $msg), 200);
    }

    public function display(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = Inspectiontype::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('sno', function($row){
                    $GLOBALS['count']++;
                    return $GLOBALS['count'];
                })
                ->addColumn('action', function($row){
                    $id = encrypt($row->id);
                    $editlink = route('admin.update.inspectiontype', ['id' => $id]);
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'><i class='fas fa-edit'></i></a><a href='javascript:void(0)' data-id='$id' class='delete btn red-btn btn-danger  '  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'><i class='fa fa-trash' aria-hidden='true'></i></a></div>";
                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y h:i a', strtotime($row->created_at));
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "inactive") {
                        $class = "btn btn-danger ms-2 status";
                        $btntext = "Inactive";
                    } else {
                        $class = "btn btn-success ms-2 status";
                        $btntext = "Active";
                    }
                    $id = encrypt($row->id);
                    $statusBtn = "<div class='d-flex justify-content-center'><a href='javascript:void(0)' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Task $btntext' class='$class'>$btntext</a></div>";
                    return $statusBtn;
                })
                ->rawColumns(['sno','created_at','action','status'])
                ->make(true);
        }
    }
}
