<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:8",
        ],
        [
            "required" => "Field is required.",
            "email.email" => "Please enter a valid email.",
        ]
        );
        $role = Role::findByName('admin');
        $user = User::create([
                "name" => $request['name'],
                "email" => $request['email'],
                "password" => Hash::make($request['password']),
                "email_verified_at" => Carbon::now()->timestamp,
                "approved"    => "Approved",
        ]);
        $user->assignRole([$role->id]);
        return response()->json(["success"=>true,"message"=>"Admin Created Successfully.","Userdetails"=>$user], 200);
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
