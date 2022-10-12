<?php

namespace App\Http\Controllers\Company\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
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
        ]);
        User::create([
            "name" => $request['employeename'],
            "email" => $request['employeeemail'],
            "company_phonenumber" => $request['employeemobile'],
            "company_address" => $request['employeeaddress'],
            "city" => $request['employeecity'],
            "state" => $request['employeestate'],
            "zipcode" => $request['employeezipcode'],
            "password" => Hash::make($request['password']),
            "role" => "4",
        ]);
        return  redirect()->back()->with("msg","Record Created Successfully");
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
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
