<?php

namespace App\Http\Controllers\Admin\Inspector;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InspectorController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:inspector-list|inspector-create|inspector-edit|inspector-delete', ['only' => ['index','show']]);
         $this->middleware('permission:inspector-create', ['only' => ['create','store']]);
         $this->middleware('permission:inspector-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:inspector-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // $data
        return view('admin.inspector.inspectorViewList');
    }


    public function create()
    {
        return view('admin.inspector.registerInspector');
    }

    public function store(Request $request,User $inspector)
    {
        // dd($request->all());
        $request->validate([
            'company_name'               => 'required',
            'name'                       => 'required',
            'number'                     => 'required',
            'license_number'             => 'required',
            'area_coverage'              => 'required',
            'color_code'                 => 'required',
            'email'                      => 'required|unique:users|max:255',
            'password'                   => 'required',
        ]);
        $user = User::create([
            'company_name' => $request['company_name'],
            'name' => $request['name'],
            'mobile_number' => $request['number'],
            'email' => $request['email'],
            'license_number' => $request['license_number'],
            'area_coverage' => $request['area_coverage'],
            'color_code' => $request['color_code'],
            'password' => Hash::make($request['password']),
            'inspector_id' => 'INS'.time().rand(1,100),
        ]);
        $user->save();
        $role = Role::findByName('inspector');
        $user->assignRole([$role->id]);
        return redirect()->route('admin.view.inspector')->with('msg','Record Save Successfully.');
      
    }
    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        if(isset($request['id']) && !empty($request['id']))
        {   
            $data = User::where('id', decrypt($request['id']))->first();
            return view('admin.inspector.registerInspector')->with(["data"=>$data]);
        }
        else
        {
            return redirect()->back()->with("msg","Record Created Successfully");
        }
    }

    public function submitUpdate(Request $request,User $inspector)
    {
        if(isset($request['id']) && !empty($request['id']))
        {
            User::where('id',decrypt($request['id']))->update([
                "company_name" => $request->company_name,
                "name" => $request->name,
                "mobile_number" => $request->number,
                "license_number" => $request->license_number,
                "area_coverage" => $request->area_coverage,
                "color_code" => $request->color_code,
                "email" => $request->email,
                "password" => $request->password,
            ]);
            return redirect()->route('admin.view.inspector')->with("msg","Record Updated Successfully");
        }
      
    }

    public function destroy(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        User::where('id', decrypt($request['id']))->delete();
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
        $status = User::where('id', decrypt($request['id']))->first('status');
        $status= ($status['status'] == "active") ? "inactive" : "active";
        User::where('id',decrypt($request['id']))->Update([
            "status" => $status,
        ]);
        $msg = "Status Updated Successfully";
        return response()->json(array("msg" => $msg), 200);
    }

    public function display(Request $request)
    {
    //    dd($request->all());
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = User::role('inspector')->latest()->get(['id','company_name','name','color_code','mobile_number','email','status','license_number','area_coverage']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $id = encrypt($row->id);
                    $editlink = route('admin.show.inspector', ['id' => $id]);
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'><i class='fas fa-edit'></i></a><a href='javascript:void(0)' data-id='$id' class='delete btn red-btn btn-danger  '  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'><i class='fa fa-trash' aria-hidden='true'></i></a></div>";
                    return $btn;
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
                ->rawColumns(['id','action','status'])
                ->make(true);
        }
    }
}
