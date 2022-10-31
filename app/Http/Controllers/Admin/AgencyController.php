<?php

namespace App\Http\Controllers\Admin;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class AgencyController extends Controller
{
    //
    public function index()
    {
        return view('admin.agency.create-agency');
    }

    public function store(Request $request,User $inspector)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name'                => 'required',
            'company_address'             => 'required',
            'city'                        => 'required',
            'zip_code'                    => 'required',
            'company_phonenumber'         => 'required',
            'direct_number'               => 'required',
        ]);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'company_name' => $request['company_name'],
            'company_address' => $request['company_address'],
            'city' => $request['city'],
            'zip_code' => $request['zip_code'],
            'company_phonenumber' => $request['company_phonenumber'],
            'direct_number' => $request['direct_number'],
        ]);
        $user->save();
        $role = Role::findByName('company');
        $user->assignRole([$role->id]);
        return redirect()->route('admin.agency.agency-view')->with('msg','Record Save Successfully.');
      
    }

    public function show()
    {
        return view('admin.agency.agencyViewList');
    }

    public function display(Request $request)
    {
        //    dd($request->all());
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = User::role('company')->latest()->get(['id', 'company_name', 'name', 'email', 'company_address', 'direct_number', 'company_phonenumber', 'zip_code', 'status']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $editlink = route('admin.agency.agency-show', ['id' => $id]);
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
                ->rawColumns(['id', 'action', 'status'])
                ->make(true);
        }
    }

    public function update(Request $request)
    {
        if (isset($request['id']) && !empty($request['id'])) {
            $data = User::where('id', decrypt($request['id']))->first();
            return view('admin.agency.create-agency')->with(["data" => $data]);
        } else {
            return redirect()->back()->with("msg", "Record Created Successfully");
        }
    }

    public function submitUpdate(Request $request, User $inspector)
    {
        if (isset($request['id']) && !empty($request['id'])) {
            $request->validate([
                'company_name'               => 'required',
                'name'                       => 'required',
                'email'                      => 'required',
                'company_address'            => 'required',
                'direct_number'              => 'required',
                'company_phonenumber'        => 'required',
                'zip_code'                   => 'required',
                'password'                   => ['nullable', 'min:8'],
            ]);
            if (isset($request['password']) && !empty($request['password'])) {
                User::where('id', decrypt($request['id']))->update([
                    "company_name" => $request->company_name,
                    "name" => $request->name,
                    "email" => $request->email,
                    "company_address" => $request->company_address,
                    "direct_number" => $request->direct_number,
                    "company_phonenumber" => $request->company_phonenumber,
                    "zip_code" => $request->zip_code,
                    "password" => Hash::make($request->password),
                ]);
            } else {
                User::where('id', decrypt($request['id']))->update([
                    "company_name" => $request->company_name,
                    "name" => $request->name,
                    "email" => $request->email,
                    "company_address" => $request->company_address,
                    "direct_number" => $request->direct_number,
                    "company_phonenumber" => $request->company_phonenumber,
                    "zip_code" => $request->zip_code,

                ]);
            }
            return redirect()->route('admin.agency.agency-view')->with("msg", "Record Updated Successfully");
        }
    }

    public function status(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        $status = User::where('id', decrypt($request['id']))->first('status');
        $status = ($status['status'] == "active") ? "inactive" : "active";
        User::where('id', decrypt($request['id']))->Update([
            "status" => $status,
        ]);
        $msg = "Status Updated Successfully";
        return response()->json(array("msg" => $msg), 200);
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
}
