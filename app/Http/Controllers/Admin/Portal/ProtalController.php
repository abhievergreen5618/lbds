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
        $option->updatesetting($request->all());
        return back()->with('msg', 'Mail Configuration Updated Successfully');
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
