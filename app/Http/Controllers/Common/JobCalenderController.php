<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RequestModel;

class JobCalenderController extends Controller
{
    public function index(Request $request)
    {
        $inslist = User::role('inspector')->pluck("name", "id");
        return view('common.jobcalender')->with([
            "inslist" => $inslist,
        ]);
    }
    public function adminevents(Request $request)
    {
        if($request->ajax()) {
            $requests = RequestModel::whereNotNull("company_id", "")->get();
            dd($requests);
        }
    }
}
