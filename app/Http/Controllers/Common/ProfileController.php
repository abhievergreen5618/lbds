<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $data = auth()->user();
        return view('common.profile')->with("data", $data);
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
        $request->validate([
            "name" => "required",
            "mobile_number" => "required|numeric|digits:10",
        ],
        [
            "mobile_number.digits" => "Please enter a valid phone number",
            "required" => "Field is required.",
        ]);
            if($request->file('profile_img'))
            {
            $rand = rand(10, 5000);
            $name = $request->file('profile_img')->getClientOriginalName();
            $fileName = time() . $rand . '.' . $request->file('profile_img')->getClientOriginalExtension();
            $request->file('profile_img')->move(public_path('images/profile'), $fileName);
            }
            else
            {
                $fileName = "";
            }
            $user =Auth::user();
            $user->name = $request['name'];
            $user->mobile_number = $request['mobile_number'];
            $user->save();
            return back()->with('msg','Profile Updated Successfully');
    }
    public function updatepass(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'old_password' => [
                    'required', function ($attribute, $value, $fail) {
                        if (!Hash::check($value, Auth::user()->password)) {
                            $fail('Old Password didn\'t match');
                        }
                    },
                ],
                "password" => "required|min:8|confirmed",
            ],
            [
                "required" => "Field is required.",
                "confirmed" => "The password confirmation does not match.",
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {
            $user =Auth::user();
            $user->password = Hash::make($request['password']);
            $user->save();
            return back()->with('msg','Profile Updated Successfully');
        }
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
