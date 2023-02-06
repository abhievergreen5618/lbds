<?php

namespace App\Http\Controllers\Admin\Portal;

use App\Http\Controllers\Controller;
use App\Models\Options;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Options $options)
    {
        $data = $options->get_portal_setting();
        return view('admin.portal.emailTemplate')->with("data", $data);
    }

    /**
     * Store a newly created Verification Email  template in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function emailStore(Request $request,Options $options)
    {
        $options->updatesetting($request->all());
        return back()->with('msg', 'Email Verification Template Updated Successfully');
    }

    /**
     * Store a newly created Request Assigned Email  template  in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignEmailStore(Request $request,Options $options)
    {
        $options->updatesetting($request->all());
        return back()->with('msg', 'Request Assigned Email Template Updated Successfully');
    }

    /**
     * Store a newly created Request Scheduled Email  template  in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function scheduledEmailStore(Request $request,Options $options)
    {
        $options->updatesetting($request->all());
        return back()->with('msg', 'Request Scheduled Template Updated Successfully');
    }  

    /**
     * Store a newly created Request Underreview Email  template  in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function underreviewEmailStore(Request $request,Options $options)
    {
        $options->updatesetting($request->all());
        return back()->with('msg', 'Request Underreview Template Updated Successfully');
    }

    /**
     * Store a newly created Request Completed Email  template  in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function completedEmailStore(Request $request,Options $options)
    {
        $options->updatesetting($request->all());
        return back()->with('msg', 'Request Completed Template Updated Successfully');
    }
    
    public function ReminderStore(Request $request,Options $options)
    {
        $options->updatesetting($request->all());
        return back()->with('msg','Inspection Reminder Template Updated Successfully');
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
