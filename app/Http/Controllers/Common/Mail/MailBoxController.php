<?php

namespace App\Http\Controllers\Common\Mail;

use App\Http\Controllers\Controller;
use App\Models\EmailModel;
use App\Models\RequestModel;
use Illuminate\Http\Request;

class MailBoxController extends Controller
{

    public function index()
    {
        $sentmail = EmailModel::where('status','sent')->limit(10)->get();
        $sentmailcount = EmailModel::where('status','sent')->count();
        $draftmailcount = EmailModel::where('status','draft')->count();
        return view('common.email.mailbox')->with(["sentmail"=>$sentmail,"sentmailcount"=>$sentmailcount,"draftmailcount"=>$draftmailcount,"sent"=>true]);
    }
    public function draft()
    {
        $sentmail = EmailModel::where('status','draft')->limit(10)->get();
        $sentmailcount = EmailModel::where('status','sent')->count();
        $draftmailcount = EmailModel::where('status','draft')->count();
        return view('common.email.mailbox')->with(["sentmail"=>$sentmail,"sentmailcount"=>$sentmailcount,"draftmailcount"=>$draftmailcount,"draft"=>true]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(Request $request,MailBoxController $mailhelper)
    {
        $readmail = EmailModel::where(['id'=>decrypt($request->id)])->first();
        $sentmailcount = EmailModel::where('status','sent')->count();
        $draftmailcount = EmailModel::where('status','draft')->count();
        return view('common.email.read-mail')->with(["mailhelper"=>$mailhelper,"readmail"=>$readmail,"sentmailcount"=>$sentmailcount,"draftmailcount"=>$draftmailcount]);
    }

    public static function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
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
