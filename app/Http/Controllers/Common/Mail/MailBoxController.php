<?php

namespace App\Http\Controllers\Common\Mail;

use App\Http\Controllers\Controller;
use App\Models\EmailModel;
use Illuminate\Http\Request;

class MailBoxController extends Controller
{

    public function index()
    {
        $sentmail = EmailModel::where('status','sent')->get();
        $sentmailcount = EmailModel::where('status','sent')->count();
        $draftmailcount = EmailModel::where('status','draft')->count();
        return view('common.email.mailbox')->with(["sentmail"=>$sentmail,"sentmailcount"=>$sentmailcount,"draftmailcount"=>$draftmailcount]);
    }
    public function draft()
    {
        $sentmail = EmailModel::where('status','draft')->get();
        $sentmailcount = EmailModel::where('status','sent')->count();
        $draftmailcount = EmailModel::where('status','draft')->count();
        return view('common.email.mailbox')->with(["sentmail"=>$sentmail,"sentmailcount"=>$sentmailcount,"draftmailcount"=>$draftmailcount]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(Request $request)
    {
        $readmail = EmailModel::where(['id'=>decrypt($request->id),'status'=>'sent'])->first();
        $sentmailcount = EmailModel::where('status','sent')->count();
        $draftmailcount = EmailModel::where('status','draft')->count();
        return view('common.email.read-mail')->with(["readmail"=>$readmail,"sentmailcount"=>$sentmailcount,"draftmailcount"=>$draftmailcount]);
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
