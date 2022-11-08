<?php

namespace App\Http\Controllers\Admin\Agency;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Carbon\Carbon;
use DB;

class AgencyApprovalController extends Controller
{
     // for Status List
    public function statusApproved()
    {
        return view('admin.agency.agencyPendingList');
    }
    public function statusUpadteList(Request $request)
    {
     
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = User::role('company')->where('approved','Pending')->get(['id','company_name','name', 'email', 'zip_code','approved']);
            // dd(count($data));
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('approved', function ($row) {
                      $returnvalue = "<select class='form-control approved' name='approved' id='approved'>";
                      $arr = ["Disapproved","Pending","Approved"];
                      foreach($arr as $value)
                      {
                        $selected = ($value === $row->approved) ? "selected" : "";
                        $id=encrypt($row->id);
                        // dd($id);
                        $returnvalue =  $returnvalue."<option value='$value'  data-id='$id' $selected>$value</option>";
                      }
                $returnvalue = $returnvalue . "</select>";
                return $returnvalue;
            })->rawColumns(['id','approved'])
                ->make(true);
        }
    }


    public function approvalUpdate(Request $request)
    {
        if (isset($request['id']) && !empty($request['id'])) {
            $data = User::where('id', decrypt($request['id']))->first();
            return view('admin.userApprovalView')->with(["data" => $data]);
        }
    }

    public function approvalUpdateSubmit(Request $request)
    {
      if (isset($request['id']) && !empty($request['id'])) {
          User::where('id', decrypt($request['id']))->update([
                "approved" => $request->approved
            ]);
        }
        return redirect()->route('admin.adminlist.view')->with("msg", "Record Updated Successfully");
    }

    public function approvalStatusUpdate(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                "id" => 'required',
                "status" => 'required',
            ]
        );
        User::where('id', decrypt($request['id']))->Update([
            "approved" => $request['status'],
        ]);
        $msg = "Status Updated Successfully";
        return response()->json(array("msg" => $msg), 200);
    }

    // //for disapproved list
    public function disApprovedList()
    {
        return view('admin.agency.agencyDisapprovedList');
    }
    public function statusDisApprovedList(Request $request){
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = User::role('company')->where('approved','Disapproved')->get(['id','company_name','name', 'email', 'zip_code','approved']);
            // dd(count($data));
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('approved', function ($row) {
                      $returnvalue = "<select class='form-control approved' name='approved' id='approved'>";
                      $arr = ["Disapproved","Pending","Approved"];
                      foreach($arr as $value)
                      {
                        $selected = ($value === $row->approved) ? "selected" : "";
                        $id=encrypt($row->id);
                        // dd($id);
                        $returnvalue =  $returnvalue."<option value='$value'  data-id='$id' $selected>$value</option>";
                      }
                $returnvalue = $returnvalue . "</select>";
                return $returnvalue;
            })->rawColumns(['id','approved'])
                ->make(true);
        }
    }
}
