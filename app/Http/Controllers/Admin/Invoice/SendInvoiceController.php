<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SendInvoice;

class SendInvoiceController extends Controller
{
    public function index()
    {
        return view('admin.invoice.addsendinvoice');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "description"=>"required",
            "status"=>"required",
        ]);
        if(isset($request['id']) && !empty($request['id']))
        {
            SendInvoice::where('id',decrypt($request['id']))->update([
                "name" => $request->name,
                "description" => $request->description,
                "status" => $request->status,
            ]);
            return redirect()->route('admin.allsendinvoice')->with("msg","Record Updated Successfully");
        }
        else
        {
            SendInvoice::create([
                "name" => $request->name,
                "description" => $request->description,
                "status" => $request->status,
            ]);
            return redirect()->route('admin.allsendinvoice')->with("msg","Record Created Successfully");
        }
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
    public function show()
    {
        return view('admin.invoice.allsendinvoice');
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
        if(isset($request['id']) && !empty($request['id']))
        {   
            $data = SendInvoice::where('id', decrypt($request['id']))->first();
            return view('admin.inspection.addSendInvoice')->with(["data"=>$data]);
        }
        else
        {
            return redirect()->back()->with("msg","Record Created Successfully");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        SendInvoice::where('id', decrypt($request['id']))->delete();
        $msg = "Deleted Successfully";
        return response()->json(array("msg" => $msg), 200);
    }


    public function status(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        $status = SendInvoice::where('id', decrypt($request['id']))->first('status');
        $status= ($status['status'] == "active") ? "inactive" : "active";
        SendInvoice::where('id', decrypt($request['id']))->Update([
            "status" => $status,
        ]);
        $msg = "Status Updated Successfully";
        return response()->json(array("msg" => $msg), 200);
    }

    public function display(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = SendInvoice::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('sno', function($row){
                    $GLOBALS['count']++;
                    return $GLOBALS['count'];
                })
                ->addColumn('action', function($row){
                    $id = encrypt($row->id);
                    $editlink = route('admin.update.SendInvoice', ['id' => $id]);
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'><i class='fas fa-edit'></i></a><a href='javascript:void(0)' data-id='$id' class='delete btn red-btn btn-danger  '  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'><i class='fa fa-trash' aria-hidden='true'></i></a></div>";
                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y h:i a', strtotime($row->created_at));
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "inactive") {
                        $class = "btn btn-danger ms-2 status";
                        $btntext = "Inactive";
                    } else {
                        $class = "btn btn-success ms-2 status";
                        $btntext = "Active";
                    }
                    $id = encrypt($row->id);
                    $statusBtn = "<div class='d-flex justify-content-center'><a href='javascript:void(0)' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Task $btntext' class='$class'>$btntext</a></div>";
                    return $statusBtn;
                })
                ->rawColumns(['sno','created_at','action','status'])
                ->make(true);
        }
    }
}
