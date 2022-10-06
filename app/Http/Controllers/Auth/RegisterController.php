<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'company_name'                => 'required',
            'company_address'             => 'required',
            'city'                        => 'required|max:11',
            'zip_code'                    => 'required|max:11',
            'company_phonenumber'         => 'required',
            'direct_number'               => 'required',
        ],
        [
            "required" => "Field is required."
        ]
    );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function store(Request $request, User $user)
    {
        $request->validate([
            'company_name'                => 'required',
            'company_address'             => 'required',
            'city'                        => 'required|max:11',
            'zip_code'                    => 'required|max:11',
            'company_phonenumber'         => 'required',
            'name'                        => 'required',
            'direct_number'               => 'required',
            'email'                       => 'required|unique:users|max:255',
            'password'                    => 'required|min:6',
        ],
        [
            "required" => "Field is required."
        ]
    );

        $user                       = new User();
        $user->company_name         =$request->company_name;
        $user->company_address      =$request->company_address;
        $user->city                 =$request->city;
        $user->zip_code             =$request->zip_code;
        $user->company_phonenumber  =$request->company_phonenumber;
        $user->name                 =$request->name;
        $user->direct_number        =$request->direct_number;
        $user->email                =$request->email;
        $user->password             =Hash::make($request->password);
        $user->role                 ='3';
        $user->save();

        return redirect()->route('login')->with(["msg"=>"Registered Successfully"]);

    }
}
