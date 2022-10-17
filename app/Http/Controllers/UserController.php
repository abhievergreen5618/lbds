<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use DataTables;


class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.users.alluserlist');
    }
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
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
            $data = User::latest()->get(['id','name','email','status','created_at']);
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('sno', function($row){
                $GLOBALS['count']++;
                return $GLOBALS['count'];
            })
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
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y h:i a', strtotime($row->created_at));
                })
                ->rawColumns(['sno','created_at','id','action','status'])
                ->make(true);
        }
    }
}
