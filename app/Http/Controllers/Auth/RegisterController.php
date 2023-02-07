<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name'                => 'required',
            'company_address'             => 'required',
            'city'                        => 'required',
            'zip_code'                    => 'required',
            'company_phonenumber'         => 'required|regex:/^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/',
            'direct_number'               => 'required|regex:/^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/',
        ],
        [
            "required" => "Field is required."
        ]
        );
    }
    
    protected function create(array $data)
    {
        $role = Role::findByName('company');
        $user = User::create([
            'company_name' => $data['company_name'],
            'company_address' => $data['company_address'],
            'city' => $data['city'],
            'zip_code' => $data['zip_code'],
            'company_phonenumber' => $data['company_phonenumber'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'direct_number' => $data['direct_number'],
        ]);
        $user->assignRole([$role->id]);
        $role->givePermissionTo('request-create');
        return $user;
    }
}
