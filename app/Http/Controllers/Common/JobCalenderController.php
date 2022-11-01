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
            $start = $request['start']; 
            $end = $request['end'];
            $filter = $request['filter'];
            $req = ($request['filter'] == "all") ? RequestModel::leftjoin("users","users.id","=","request_models.assigned_ins")->whereBetween('request_models.schedule_at', [$start,$end])->get(["request_models.id","request_models.assigned_ins","request_models.applicantname","request_models.applicantemail","request_models.applicantmobile","request_models.schedule_at","request_models.schedule_time","request_models.status","request_models.address","request_models.state","request_models.city","request_models.zipcode","users.name"]) : RequestModel::leftjoin("users","users.id","=","request_models.assigned_ins")->where('assigned_ins',decrypt($filter))->whereBetween('request_models.schedule_at', [$start,$end])->get(["request_models.id","request_models.assigned_ins","request_models.applicantname","request_models.applicantemail","request_models.applicantmobile","request_models.schedule_at","request_models.schedule_time","request_models.status","request_models.address","request_models.state","request_models.city","request_models.zipcode","users.name"]);
            return response()->json(["events"=>$req]);
        }
    }
}
