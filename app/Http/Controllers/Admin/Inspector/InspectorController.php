<?php

namespace App\Http\Controllers\Admin\Inspector;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;

class InspectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data
        return view('admin.inspector.inspectorViewList');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inspector.registerInspector');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $inspector)
    {
        // dd($request->all());
        $request->validate([
            'company_name'               => 'required',
            'name'                        => 'required',
            'number'                      => 'required',
            'license_number'              => 'required',
            'area_coverage'               => 'required',
            'color_code'                 => 'required',
            'email'                       => 'required|unique:users|max:255',
            'password'                    => 'required',
        ]);

      
        $inspector                       = new User();
        $inspector->company_name         =$request->company_name;
        $inspector->name                 =$request->name;
        $inspector->number               =$request->number;
        $inspector->email                =$request->email;
        $inspector->license_number       =$request->license_number;
        $inspector->area_coverage        =$request->area_coverage;
        $inspector->color_code           =$request->color_code;
        $inspector->password             =Hash::make($request->password);
        $inspector->role                 ='2';
        $inspector->inspector_id        ='INS'.time().rand(1,100);
        // dd($inspector);
        $inspector->save();

        return redirect()->route('admin.view.inspector')->with('msg','Record Save Successfully.');
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
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
                "number" => $request->number,
                "license_number" => $request->license_number,
                "area_coverage" => $request->area_coverage,
                "color_code" => $request->color_code,
                "email" => $request->email,
                "password" => $request->password,
            ]);
            return redirect()->route('admin.view.inspector')->with("msg","Record Updated Successfully");
        }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
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
            $data = User::where('role','2')->latest()->get(['id','company_name','name','color_code','number','email','status','license_number',
            'area_coverage']);
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
