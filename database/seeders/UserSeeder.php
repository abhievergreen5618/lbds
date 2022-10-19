<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            "name" => "admin",
            "email" => "testadmin@gmail.com",
            "password" => Hash::make("12345678"),
            "email_verified_at" => Carbon::now()->timestamp,
        ]);
        $role = Role::create(['name' => 'admin']);
        
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);

        $user = User::create([
            "name" => "Bishoples",
            "email" => "bishoples@gmail.com",
            "password" => Hash::make("12345678"),
            "email_verified_at" => Carbon::now()->timestamp,
        ]);
        
        // $permissions = Permission::pluck('id','id')->all();
   
        // $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
        $user = User::create([
            "name" => "inspector",
            "email" => "testinspector@gmail.com",
            "password" => Hash::make("12345678"),
            "email_verified_at" => Carbon::now()->timestamp,
        ]);
        $role = Role::create(['name' => 'inspector']);
        $user->assignRole([$role->id]);
        
        $user = User::create([
            "name" => "company",
            "email" => "testcompany@gmail.com",
            "company_name" => "Wind Mitigation",
            "email_verified_at" => Carbon::now()->timestamp,
            "password" => Hash::make("12345678"),
        ]);
        $role = Role::create(['name' => 'company']);
        $user->assignRole([$role->id]);
    }
}
