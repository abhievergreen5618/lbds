<?php

namespace App\Http\Controllers\Admin\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Options;

class ProtalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Options $options)
    {
        $data = $options->get_portal_setting();
        return view('admin.portal.portalsetup')->with("data", $data);
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
    public function update(Request $request, Options $option)
    {
        $request->validate(
            [
                "name" => "required",
                "email" => "required|email",
            ],
            [
                "required" => "This field is required."
            ]
        );
        $values = $request->all();
        if ($request->file('website_logo')) {
            $rand = rand(10, 5000);
            $name = $request->file('website_logo')->getClientOriginalName();
            $fileName = time() . $rand . '.' . $request->file('website_logo')->getClientOriginalExtension();
            $request->file('website_logo')->move(public_path('images'), $fileName);
            unset($values["website_logo"]); 
            $values['website_logo'] = $fileName;
        } else {
            $fileName = "";
        }
        $option->updatesetting($values);
        // $option->envUpdate($request->all());
        return back()->with('msg', 'Website Configuration Updated Successfully');
    }

    public function updatemail(Request $request, Options $option)
    {
        $request->validate(
            [
                "mail_host" => "required",
                "mail_port" => "required",
                "mail_username" => "required",
                "mail_password" => "required",
                "mail_address" => "required",
                "mail_encryption" => "required",
            ],
            [
                "required" => "This field is required."
            ]
        );
        $option->envUpdate($request->all());
        $option->updatesetting($request->all());
        return back()->with('msg', 'Mail Configuration Updated Successfully');
    }


    public function updatepusher(Request $request, Options $options)
    {
        $request->validate(
            [
                "pusher_app_id" => "required",
                "pusher_app_key" => "required",
                "pusher_app_secret" => "required",
                "pusher_app_cluster" => "required",
            ],
            [
                "required" => "This field is required."
            ]
        );
        //   $data=array($request->all());
        $options->envUpdate($request->all());
        $options->updatesetting($request->all());

        return back()->with('msg', 'Pusher Configuration Updated Successfully');
    }

    public function updateLoginImage(Request $request, Options $options)
    {
        $values = $request->all();
        if ($request->file('login_img')) {
            $rand = rand(10, 5000);
            $name = $request->file('login_img')->getClientOriginalName();
            $fileName = time() . $rand . '.' . $request->file('login_img')->getClientOriginalExtension();
            $request->file('login_img')->move(public_path('images'), $fileName);
            unset($values["login_img"]);
            $values['login_img'] = $fileName;
        } else {
            $fileName = "";
        }
        if ($request->file('registration_img')) {
            $rand = rand(10, 5000);
            $name = $request->file('registration_img')->getClientOriginalName();
            $fileName = time() . $rand . '.' . $request->file('registration_img')->getClientOriginalExtension();
            $request->file('registration_img')->move(public_path('images'), $fileName);
            unset($values["registration_img"]);
            $values['registration_img'] = $fileName;
        } else {
            $fileName = "";
        }
        if ($request->file('registration_logo_img')) {
            $rand = rand(10, 5000);
            $name = $request->file('registration_logo_img')->getClientOriginalName();
            $fileName = time() . $rand . '.' . $request->file('registration_logo_img')->getClientOriginalExtension();
            $request->file('registration_logo_img')->move(public_path('images'), $fileName);
            unset($values["registration_logo_img"]);
            $values['registration_logo_img'] = $fileName;
        } else {
            $fileName = "";
        }
        $options->updatesetting($values);
        return back()->with('msg', 'Website Images Updated Successfully');
    }



    public function destroy($id)
    {
        //
    }
}
