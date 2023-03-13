<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function index()
    {
        $filename =  public_path("/csv/test_windmitigation-copy.csv");
        $file = fopen($filename,'r');
        $data = array();
        $i = 0;
        while (($row = fgetcsv($file, 1000, ',')) !== FALSE) 
        {
            if($i != 0)
            {
                $userfind = User::where("email",$row[9])->count();
                if($userfind == 0)
                {
                    if($row[15] == "Admin")
                    {
                        if($row[14] == "Active")
                        {
                            $user = User::create([
                                "name" => $row[8],
                                'company_name' => $row[2],
                                "email" => $row[9],
                                "company_address" => $row[3],
                                'company_phonenumber' => $row[7],
                                'mobile_number' => $row[10],
                                'color_code' => $row[17],
                                "password" => Hash::make("12345678"),
                                "email_verified_at" => Carbon::now()->timestamp,
                                "approved"    => "Approved",
                            ]);
                            $role = Role::findByName('admin');
                            $user->assignRole([$role->id]);
                            $permissions = Permission::pluck('id','id')->all();
                            $role->syncPermissions($permissions);
                            $token = \Illuminate\Support\Facades\Password::broker()->createToken($user);
                            $user->sendPasswordResetNotification($token);
                        }
                    }
                    else if($row[15] == "Inspector")
                    {
                        if($row[14] == "Active")
                        {
                        $user = User::create([
                            'company_name' => $row[2],
                            'name' => $row[8],
                            'mobile_number' => $row[10],
                            'email' => $row[9],
                            'license_number' => $row[12],
                            'area_coverage' => $row[13],
                            'color_code' => $row[17],
                            'password' => Hash::make("12345678"),
                            'inspector_id' => 'INS' . time() . rand(1, 100),
                            'approved' => "Approved",
                            'email_verified_at' => Carbon::now()->timestamp,
                        ]);
                        $user->save();
                        $role = Role::findByName('inspector');
                        $role->givePermissionTo(['request-list','job-calendar']);
                        $user->assignRole([$role->id]);
                        $token = \Illuminate\Support\Facades\Password::broker()->createToken($user);
                        $user->sendPasswordResetNotification($token);
                        }
                    }
                    else if($row[15] == "Agency")
                    {
                        if($row[14] == "Active")
                        {
                        $user = User::create([
                            'name' => $row[8],
                            'email' => $row[9],
                            'password' => Hash::make("12345678"),
                            'company_name' => $row[2],
                            'company_address' => $row[3],
                            'city' => $row[4],
                            'zip_code' => $row[6],
                            'company_phonenumber' => $row[7],
                            'color_code' => $row[17],
                            'email_verified_at'=>Carbon::now()->timestamp,
                            'approved' => "Approved",
                        ]);
                        $user->save();
                        $role = Role::findByName('company');
                        $role->givePermissionTo(['request-create','request-list','employee-list','employee-create','employee-edit','employee-delete','request-edit']);
                        $user->assignRole([$role->id]);
                        $token = \Illuminate\Support\Facades\Password::broker()->createToken($user);
                        $user->sendPasswordResetNotification($token);
                        }
                    }
                }
                else
                {
                    continue;
                }
            }
            $i++;
        }
        dd('Password reset emails sent successfully');
    }
}
