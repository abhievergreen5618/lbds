<?php

namespace App\Http\Controllers\Company\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.employee.employee-create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate(
            [
                "employeename" => "required",
                "employeeemail" => "required",
                "employeemobile" => "required",
                "employeeaddress" => "required",
                "employeecity" => "required",
                "employeestate" => "required",
                "employeezipcode" => "required",
                'password' => 'required| min:8 |confirmed',
                'password_confirmation' => 'required| min:8',
            ],
            [
                "required" => "This field is required.",
                "employeepassword" => "The password confirmation does not match.",
            ]
        );

        $role = Role::findByName('employee');
        // dd($request->employeestate);
        $user = User::create([
            "name" => $request['employeename'],
            "email" => $request['employeeemail'],
            "company_phonenumber" => $request['employeemobile'],
            "company_address" => $request['employeeaddress'],
            "city" => $request['employeecity'],
            "zip_code" => $request['employeezipcode'],
            "state" => $request['employeestate'],
            "password" => Hash::make($request['password']),
            // "role" => "4",
        ]);
        $user->assignRole([$role->id]);

        return  redirect()->route('admin.employee.view')->with("msg", "Record Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //employee list
        return view('company.employee.employee-list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function display(Request $request)
    {
        //    dd($request->all());
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = User::role('employee')->latest()->get(['id','name', 'email', 'company_phonenumber', 'company_address', 'city', 'state', 'zip_code']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $editlink = route('admin.show.employee', ['id' => $id]);
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'><i class='fas fa-edit'></i></a><a href='javascript:void(0)' data-id='$id' class='delete btn red-btn btn-danger  '  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'><i class='fa fa-trash' aria-hidden='true'></i></a></div>";
                    return $btn;
                })
                ->rawColumns(['id', 'action'])
                ->make(true);
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
        //
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        User::where('id', decrypt($request['id']))->delete();
        $msg = "Deleted Successfully";
        return response()->json(array("msg" => $msg), 200);
    }

//
    public function update(Request $request)
    {
        if(isset($request['id']) && !empty($request['id']))
        {
            $data = User::where('id', decrypt($request['id']))->first();
            // dd($data);
            return view('company.employee.employee-create')->with(["data"=>$data]);
        }
        else
        {
            return redirect()->back()->with("msg","Record Created Successfully");
        }
    }


    public function submitUpdate(Request $request)
    {
        if(isset($request['id']) && !empty($request['id']))
        {
            User::where('id',decrypt($request['id']))->update([
            "name" => $request['employeename'],
            "email" => $request['employeeemail'],
            "company_phonenumber" => $request['employeemobile'],
            "company_address" => $request['employeeaddress'],
            "city" => $request['employeecity'],
            "state" => $request['employeestate'],
            "zip_code" => $request['employeezipcode'],
            "password" => Hash::make($request['password']),
            ]);
            return redirect()->route('admin.employee.view')->with("msg","Record Updated Successfully");
        }

    }

}
