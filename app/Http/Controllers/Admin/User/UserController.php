<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use DataTables;


class UserController extends Controller
{
    
    function __construct()
    {
        //  $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-list', ['only' => ['showRoles','display']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['editRole','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    // public function index(Request $request)
    // {
    //     $data = User::orderBy('id','DESC')->paginate(5);
    //     return view('admin.users.index',compact('data'))
    //         ->with('i', ($request->input('page', 1) - 1) * 5);
    // }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        DB::table('users')->where('id',$user->id)->update(['approved'=>"Approved"]);
        return redirect()->route('admin.users.view')
                        ->with('msg','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRole(Request $request)
    {

        if (isset($request['id']) && !empty($request['id'])) {
            $user = User::where('id', decrypt($request['id']))->first();
           $roles= Role::pluck('name','name')->all();
           $userRole = $user->roles->pluck('name','name')->all();
           return view('admin.users.edit',compact('user','roles','userRole'));
        }
        else{
            return redirect()->back()->with("msg", "Record Created Successfully"); 
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
        return redirect()->route('admin.users.view')->with('msg','User updated successfully');
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
        User::where('id', decrypt($request['id']))->delete();
        $msg = "Deleted Successfully";
        return response()->json(array("msg" => $msg), 200);
    }

    public function showRoles(){
        return view('admin.users.index');
    }

    public function display(Request $request)
    {
        if ($request->ajax()) {
            $GLOBALS['count'] = 0;
            $data = User::get(['id','name','email']);
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('sno', function($row){
                $GLOBALS['count']++;
                return $GLOBALS['count'];
            }) 
             ->addColumn('roles', function ($row) {
                $user = User::find($row->id);
                if (!empty($user->getRoleNames())) {
                    foreach($user->getRoleNames() as $v)
                    {
                     $btn= $btn+"<label class='badge badge-success'> $v</label><br>";
                    }
                 
                }

                return $btn;
            })
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $editlink = route('admin.users.show', ['id' => $id]);
                    $btn = "<div class='d-flex justify-content-around'><a href='$editlink' data-id='$id' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn limegreen btn-primary  edit'><i class='fas fa-edit'></i></a><a href='javascript:void(0)' data-id='$id' class='delete btn red-btn btn-danger  '  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'><i class='fa fa-trash' aria-hidden='true'></i></a></div>";
                    return $btn;
                })  
                ->rawColumns(['id','sno','roles' ,'action'])
                ->make(true);
        }
    }

  
}
