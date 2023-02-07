<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RequestModel;
use Illuminate\Support\Facades\Auth;

class JobCalenderController extends Controller
{
    public function index(Request $request)
    {
        $inslist = User::role('inspector')->pluck("name", "id");
        $agencylist = User::role('company')->pluck("name", "id");
        return view('common.jobcalender')->with([
            "inslist" => $inslist,
            "agencylist" => $agencylist,
        ]);
    }
    public function adminevents(Request $request)
    {
        if ($request->ajax()) {
            $returnarr = [];
            $start = $request['start'];
            $end = $request['end'];
            $filter = $request['filter'];
            // $req = ($request['filter'] == "all") ? RequestModel::leftjoin("users", "users.id", "=", "request_models.assigned_ins")->whereBetween('request_models.scheduled_at', [$start, $end])->get(["request_models.id", "request_models.assigned_ins", "request_models.applicantname", "request_models.applicantemail", "request_models.applicantmobile", "request_models.scheduled_at", "request_models.schedule_time", "request_models.status", "request_models.address", "request_models.state", "request_models.city", "request_models.zipcode", "users.name"]) : RequestModel::leftjoin("users", "users.id", "=", "request_models.assigned_ins")->where('assigned_ins', decrypt($filter))->whereBetween('request_models.scheduled_at', [$start, $end])->get(["request_models.id", "request_models.assigned_ins", "request_models.applicantname", "request_models.applicantemail", "request_models.applicantmobile", "request_models.scheduled_at", "request_models.schedule_time", "request_models.status", "request_models.address", "request_models.state", "request_models.city", "request_models.zipcode", "users.name"]);
            $req = ($request['filter'] == "all") ? RequestModel::leftjoin("users", "users.id", "=", "request_models.assigned_ins")->whereBetween('request_models.scheduled_at', [$start, $end])->get(["request_models.id", "request_models.assigned_ins", "request_models.applicantname", "request_models.applicantemail", "request_models.applicantmobile", "request_models.scheduled_at", "request_models.schedule_time", "request_models.status", "request_models.address", "request_models.state", "request_models.city", "request_models.zipcode", "users.name"]) : RequestModel::leftjoin("users", "users.id", "=", "request_models.assigned_ins")->orWhere('request_models.assigned_ins', '=',  decrypt($filter))->orWhere('request_models.company_id', '=',  decrypt($filter))->whereBetween('request_models.scheduled_at', [$start, $end])->get(["request_models.id", "request_models.assigned_ins", "request_models.applicantname", "request_models.applicantemail", "request_models.applicantmobile", "request_models.scheduled_at", "request_models.schedule_time", "request_models.status", "request_models.address", "request_models.state", "request_models.city", "request_models.zipcode", "users.name"]);
            if (!empty($req) && count($req) != 0) {
                foreach ($req as $key=>$value) {
                    $returnarr[$key]['id'] = $value->id;
                    $returnarr[$key]['assigned_ins'] = $value->assigned_ins;
                    $returnarr[$key]['applicantname'] = $value->applicantname;
                    $returnarr[$key]['applicantemail'] = $value->applicantemail;
                    $returnarr[$key]['applicantmobile'] = $value->applicantmobile;
                    $returnarr[$key]['scheduled_at'] = $value->scheduled_at;
                    $returnarr[$key]['schedule_time'] = $value->schedule_time;
                    $returnarr[$key]['status'] = $value->status;
                    $returnarr[$key]['address'] = $value->address;
                    $returnarr[$key]['state'] = $value->state;
                    $returnarr[$key]['city'] = $value->city;
                    $returnarr[$key]['zipcode'] = $value->zipcode;
                    $returnarr[$key]['name'] = $value->name;
                    // $returnarr[$key]['link'] = Auth::user()->hasRole("admin") ? route('requestcheck',["id"=>encrypt($value->id)]) : "#";
                    $returnarr[$key]['link'] = route('requestcheck',["id"=>encrypt($value->id)]);
                }
                $req = $returnarr;
            }
            return response()->json(["events" => $req]);
        }
    }
}
