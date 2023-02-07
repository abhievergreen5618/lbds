<?php

namespace App\Http\Controllers\Admin\Agency;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AgencyController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:agency-list & agency-create|agency-edit|agency-delete', ['only' => ['show','display']]);
         $this->middleware('permission:agency-list', ['only' => ['show','display']]);
         $this->middleware('permission:agency-create', ['only' => ['index','store']]);
         $this->middleware('permission:agency-edit', ['only' => ['update','submitUpdate']]);
         $this->middleware('permission:agency-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.agency.create-agency');
    }

    public function store(Request $request,User $inspector)
    {
        // dd($request->all());
        $request->validate(
        [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name'                => 'required',
            'company_address'             => 'required',
            'city'                        => 'required',
            'zip_code'                    => 'required',
            'company_phonenumber'         => 'required',
            'direct_number'               => 'required',
        ],
        [
            "required" => "Field is required."
        ]
        );
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'company_name' => $request['company_name'],
            'company_address' => $request['company_address'],
            'city' => $request['city'],
            'zip_code' => $request['zip_code'],
            'company_phonenumber' => $request['company_phonenumber'],
            'direct_number' => $request['direct_number'],
            'email_verified_at'=>Carbon::now()->timestamp,
        ]);
        $user->save();
        $role = Role::findByName('company');
        $user->assignRole([$role->id]);
        DB::table('users')->where('id', $user->id)->update(['approved' => "Approved"]);
        return redirect()->route('admin.agency.agency-view')->with('msg','Record Save Successfully.');
      
    }

    public function show()
    {
        return view('admin.agency.agencyViewList');
    }

    public function display(Request $request)
    {
        //    dd($request->all());
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = User::role('company')->latest()->get(['id', 'company_name', 'name', 'email', 'company_address', 'direct_number', 'company_phonenumber', 'zip_code', 'status']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $editlink = route('admin.agency.agency-show', ['id' => $id]);
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'><i class='fas fa-edit'></i></a><a href='javascript:void(0)' data-id='$id' class='delete btn red-btn btn-danger  '  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'><i class='fa fa-trash' aria-hidden='true'></i></a></div>";
                    return $btn;
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
                ->addColumn('profile', function ($row) {
                    $id = encrypt($row->id);
                    $profilelink = route('admin.agency.profile', ['id' => $id]);
                    $btn = "<div class='d-flex justify-content-around'><a href='$profilelink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Profile' class='btn btn-primary  profile'>View</a></div>";
                    return $btn;
                })
                ->rawColumns(['id', 'action', 'status','profile'])
                ->make(true);
        }
    }

    public function update(Request $request)
    {
        if (isset($request['id']) && !empty($request['id'])) {
            $data = User::where('id', decrypt($request['id']))->first();
            return view('admin.agency.create-agency')->with(["data" => $data]);
        } else {
            return redirect()->back()->with("msg", "Record Created Successfully");
        }
    }

    public function submitUpdate(Request $request, User $inspector)
    {
        if (isset($request['id']) && !empty($request['id'])) {
            $request->validate([
                'company_name'               => 'required',
                'name'                       => 'required',
                'email'                      => 'required',
                'company_address'            => 'required',
                'direct_number'              => 'required',
                'company_phonenumber'        => 'required',
                'zip_code'                   => 'required',
                'password'                   => ['nullable', 'min:8'],
            ]);
            if (isset($request['password']) && !empty($request['password'])) {
                User::where('id', decrypt($request['id']))->update([
                    "company_name" => $request->company_name,
                    "name" => $request->name,
                    "email" => $request->email,
                    "company_address" => $request->company_address,
                    "direct_number" => $request->direct_number,
                    "company_phonenumber" => $request->company_phonenumber,
                    "zip_code" => $request->zip_code,
                    "password" => Hash::make($request->password),
                ]);
            } else {
                User::where('id', decrypt($request['id']))->update([
                    "company_name" => $request->company_name,
                    "name" => $request->name,
                    "email" => $request->email,
                    "company_address" => $request->company_address,
                    "direct_number" => $request->direct_number,
                    "company_phonenumber" => $request->company_phonenumber,
                    "zip_code" => $request->zip_code,

                ]);
            }
            return redirect()->route('admin.agency.agency-view')->with("msg", "Record Updated Successfully");
        }
    }

    public function status(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        $status = User::where('id', decrypt($request['id']))->first('status');
        $status = ($status['status'] == "active") ? "inactive" : "active";
        User::where('id', decrypt($request['id']))->Update([
            "status" => $status,
        ]);
        $msg = "Status Updated Successfully";
        return response()->json(array("msg" => $msg), 200);
    }

    public function destroy(Request $request)
    {
        $request->validate(
            [
                "id" => 'required',
            ]
        );
        User::where('id', decrypt($request['id']))->delete();
        $msg = "Deleted Successfully";
        return response()->json(array("msg" => $msg), 200);
    }

    public function passwordReset(Request $request)
    {

        $data = User::where('id', decrypt($request['id']))->first();
        return view('admin.agency.passwordReset')->with(["data" => $data]);
    }

    public function updatepassword(Request $request, User $agency)
    {

        $request->validate([
            'password'                   =>  ['required', 'string', 'min:8', 'confirmed'],
        ]);
        User::where('id', decrypt($request['id']))->update([
            "password" => Hash::make($request->password),
        ]);

        return redirect()->route('admin.agency.agency-view')->with("msg", "Record Updated Successfully");
    }


     // for view particular agency profile for admin...
     public function viewProfile(Request $request){
        if (isset($request['id']) && !empty($request['id'])) {
            //
            $data=User::where('id',decrypt($request['id']))->first();
            $user_request=DB::table('request_models')->where('company_id',decrypt($request['id']))->get();

            $totalrequest=$user_request->count();  
            $pendingrequest=$user_request->where('status','pending')->count();
            $scheduledrequest=$user_request->where('status','scheduled')->count();
            $completedrequest=$user_request->where('status','completed')->count();
            //
            $pending_request=DB::table('request_models')->where('company_id',decrypt($request['id']))->where('status','pending')->take(10)->get();
            $scheduled_request=DB::table('request_models')->where('company_id',decrypt($request['id']))->where('status','scheduled')->take(10)->get();
            $completed_request=DB::table('request_models')->where('company_id',decrypt($request['id']))->where('status','completed')->take(10)->get();
            // 
            
            return view('admin.agency.profileshow')->with(["data"=>$data,"user_request"=>$user_request,"totalrequest" => $totalrequest,"pendingrequest"=>$pendingrequest,
            "scheduledrequest"=>$scheduledrequest,"completedrequest"=>$completedrequest,"pending_request"=>$pending_request,"scheduled_request"=>$scheduled_request,
            "completed_request"=>$completed_request]);
        }
    }


    // for store the values of options
     public function updateAgencyMail(Request $request, User $user)
     {  
      User::where('id',decrypt($request['id']))->update(['notification_settings'=>$request['notification_settings']]);
         return back()->with('msg', 'Email Configuration Updated Successfully');
     }
 


}
