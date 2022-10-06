<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.agency_register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        // dd($request->all());
        // User::Create($request->all());
        $validateData=$request->validate([
            'company_name '               => 'required',
            'company_address '            => 'required',
            'city'                        => 'required|max:11',
            'zip_code'                    => 'required|max:11',
            'company_phonenumber'         => 'required',
            'name'                        => 'required',
            'direct_number'               => 'required',
            'email'                       => 'required|unique:users|max:255',
            'password'                    => 'required',
        ]);

        $user                          = new User();
        $user->company_name         =$request->company_name;
        $user->company_address      =$request->company_address;
        $user->city                 =$request->city;
        $user->zip_code             =$request->zip_code;
        $user->company_phonenumber  =$request->company_phonenumber;
        $user->name                 =$request->name;
        $user->direct_number        =$request->direct_number;
        $user->email                =$request->email;
        $user->password             =Hash::make($request->password);
        $user->role                 ='3';
        $user->save();

        return redirect(route('login'));

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
