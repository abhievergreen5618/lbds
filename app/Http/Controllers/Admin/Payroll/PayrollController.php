<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\RequestModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Inspectiontype;
use App\Models\Payroll;
use DataTables;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inspector = User::role('inspector')->pluck("name", "id");

        return view('admin.payroll.allpayroll')->with(['inspector' => $inspector]);
    }

    /**
     * Display the Payroll tracker lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function display(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            if(!empty($request->pay_range))
            {
                $split_date = explode("-", $request->pay_range);
                $start = date('Y-m-d', strtotime(trim($split_date[0])));
                $end = date('Y-m-d', strtotime(trim($split_date[1])));
            }   
            if(empty($request->pay_range) && $request->assign_ins == 'all')
            {  
               $data= RequestModel::where('status', 'completed')->get(['id', 'assigned_ins', 'company_id', 'address', 'inspectiontype', 'ins_fee','completed_at']);
            }
            elseif(empty($request->pay_range) &&  $request->assign_ins != 'all'){
                $data=RequestModel::where(['status'=>'completed','assigned_ins'=>decrypt($request->assign_ins)])->get(['id', 'assigned_ins', 'company_id', 'address', 'inspectiontype', 'ins_fee','completed_at']);
            }
            elseif(!empty($request->pay_range) && $request->assign_ins == 'all'){               
                $data = RequestModel::where(['status'=>'completed'])->whereDate('pay_range_start', '>=', $start)->whereDate('pay_range_end', '<=', $end)->get(['id', 'assigned_ins', 'company_id', 'address', 'inspectiontype', 'ins_fee','completed_at']);
            }elseif(!empty($request->pay_range) && $request->assign_ins != 'all')
            {
                $data=RequestModel::where(['status'=>'completed','assigned_ins'=>decrypt($request->assign_ins)])->whereDate('pay_range_start', '>=', $start)->whereDate('pay_range_end', '<=', $end)->get(['id', 'assigned_ins', 'company_id', 'address', 'inspectiontype', 'ins_fee','completed_at']); 
            }else{
                $data= RequestModel::where('status', 'completed')->get(['id', 'assigned_ins', 'company_id', 'address', 'inspectiontype', 'ins_fee','completed_at']);
            }
        //  $data= RequestModel::where('status', 'completed')->get(['id', 'assigned_ins', 'company_id', 'address', 'inspectiontype', 'ins_fee']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('company_id', function ($row) {
                    $company_name = User::find($row->company_id);
                    return (!empty($company_name['company_name'])) ? $company_name['company_name'] : "";
                })->addColumn('assigned_ins', function ($row) {
                    $inspector_name = User::find($row->assigned_ins);
                    return (!empty($inspector_name['name'])) ? $inspector_name['name'] : "";
                })->addColumn('inspectiontype', function ($row) {
                    $returnvalue = "";
                    if (!empty($row->inspectiontype)) {
                        foreach ($row->inspectiontype as $value) {
                            $inspectiontype = Inspectiontype::where(["id" => $value])->first("name");
                            $returnvalue = $returnvalue . $inspectiontype['name'] . ",";
                        }
                    } else {
                        $returnvalue = "Inspection Type Not Applicable";
                    }
                    return $returnvalue;
                })
                ->addColumn('ins_fee', function ($row) {
                    $payroll = $row->ins_fee;
                    if (!is_null($payroll) && !empty($payroll)) {
                        return "<input type='number' class='form-control' name='ins_fee' class='ins_fee form' data-id='ins_fee' value='" . $payroll . "'>";
                    } else {
                        return "<input type='number' class='form-control' name='ins_fee' class='ins_fee' data-id='ins_fee' value='0'>";
                    }
                })
                ->addColumn('income', function ($row) {
                    $payroll = Payroll::where('request_id', $row->id)->first('income');
                    if (!is_null($payroll) && !empty($payroll)) {
                        return "<input type='number' class='form-control' name='income' class='income form' data-id='income' value='" . $payroll->income . "'>";
                    } else {
                        return "<input type='number'class='form-control' name='income' class='income' data-id='income' value='0'>";
                    }
                })
                ->addColumn('pay_range', function ($row) {
                    $payroll = Payroll::where('request_id', $row->id)->first(['pay_range_start','pay_range_end']);
                    if (!is_null($payroll) && !empty($payroll)) {
                        $payroll->pay_range_start = date("m/d/Y",strtotime($payroll->pay_range_start));
                        $payroll->pay_range_end = date("m/d/Y",strtotime($payroll->pay_range_end));
                        $payrange = $payroll->pay_range_start." - ".$payroll->pay_range_end;
                        return "<input type='text'  data-id='pay_rangedate' name='date_range' class='pay_rangedate form'  placeholder='mm-dd-yyyy - mm-dd-yyyy'  value='" .$payrange. "'>";
                    } else {
                        return "<p><input type='text' data-id='pay_rangedate' id='pay_rangedate' name='date_range' class='pay_rangedate' placeholder='mm-dd-yyyy - mm-dd-yyyy' value=''></p>";
                    }
                })
                ->addColumn('pay_date', function ($row) {
                    $payroll = Payroll::where('request_id', $row->id)->first(['pay_date']);
                    if (!is_null($payroll) && !empty($payroll)) {
                        return "<p><input type='text'  name='pay_date' class='daterangesingle form' data-id='pay_date' value='" . date('m/d/Y', strtotime($payroll->pay_date)) . "'></p>";
                    } else {
                        return "<p><input type='text'  name='pay_date' data-id='pay_date' class='daterangesingle' placeholder='dd-mm-yyyy' value='' ></p>";
                    }
                })
                ->addColumn('payment_status', function ($row) {
                    $payroll = Payroll::where('request_id', $row->id)->first(['payment_status']);
                    if (!is_null($payroll) && !empty($payroll) && $payroll['payment_status'] == "paid" ) {
                        return "<input type='checkbox' class='payment_status' data-id='payment_status' id='payment_status' name='payment_status' value='paid' checked  readonly onclick='return false'>";
                    } else {
                        return "<input type='checkbox' class='payment_status' data-id='payment_status' id='payment_status' name='payment_status' value='paid'>";
                    }
                })
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $btn = "<div class='d-flex justify-content-around'><a href='javascript:void(0);'id='savebtn'   data-id='$id' data-bs-toggle='tooltip'  data-bs-placement='top' title='Save'  class='btn limegreen btn-primary  save'>Save</a>&nbsp;<a href='javascript:void(0);' id='editbtn'  data-id='$id' data-bs-toggle='tooltip'  data-bs-placement='top' title='Edit' class='btn limegreen btn-danger edit hide' style='display:none;'>Edit</a></div>";
                    return $btn;
                })
                ->rawColumns(['id', 'ins_fee', 'income', 'pay_range', 'pay_date', 'payment_status', 'action'])
                ->make(true);
        }
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
    public function store(Request $request, Payroll $payroll)
    {

        // dd($request->all());
        $request->validate(
            [
                'id'                              => 'required|unique:payrolls',
                'data.ins_fee'                    => 'required',
                'data.income'                     => 'required',
                'data.pay_rangedate'              => 'required',
                'data.pay_date'                   => 'required',
                'data.payment_status'             => 'required',
            ],
            [
                "required" => "Field is required.",
            ]
        );
       
        $format = date('Y-m-d', strtotime($request->data['pay_date']));
        $split_date = explode("-", $request->data['pay_rangedate']);
        $start = date('Y-m-d', strtotime(trim($split_date[0])));
        $end = date('Y-m-d', strtotime(trim($split_date[1])));
        $payroll_data = Payroll::where('request_id', decrypt($request->id))->exists();
        if (empty($payroll_data)) {
            $payroll = Payroll::create([
                'request_id'      => decrypt($request->id),
                'ins_fee'         => $request->data['ins_fee'],
                'income'          => $request->data['income'],
                'pay_range_start' => $start,
                'pay_range_end'   => $end,
                'pay_date'        => $format,
                'payment_status'  => $request->data['payment_status']
            ]);
            RequestModel::where('id', decrypt($request->id))->update(['ins_fee'  => $request->data['ins_fee'],'pay_range_start' => $start,'pay_range_end'   => $end]);
            return response()->json(['msg' => 'Details Saved Successfully.', 'data' => $payroll], 200);
        } else {
            $payroll = Payroll::where('request_id', decrypt($request->id))->update([
                'ins_fee'         => $request->data['ins_fee'],
                'income'          => $request->data['income'],
                'pay_range_start' => $start,
                'pay_range_end'   => $end,
                'pay_date'        => $format,
                'payment_status'  => $request->data['payment_status']
            ]);
            RequestModel::where('id', decrypt($request->id))->update(['ins_fee'  => $request->data['ins_fee'],'pay_range_start' => $start,'pay_range_end'   => $end]);
            return response()->json(['msg' => 'Record Updated Successfully.', 'data' => $payroll], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
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
        // dd('test');
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
