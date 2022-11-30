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
            "approved"    => "Approved",
        ]);
        $role = Role::create(['name' => 'admin']);
        
        // $permissions = Permission::pluck('id','id')->all();
   
        // $role->syncPermissions($permissions);

        $role->givePermissionTo([
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'inspector-list',
            'inspector-create',
            'inspector-edit',
            'inspector-delete',
            'inspection-list',
            'inspection-create',
            'inspection-edit',
            'inspection-delete',
            'sendinvoice-list',
            'sendinvoice-create',
            'sendinvoice-edit',
            'sendinvoice-delete',
            'user-list',
            // 'user-create',
            'user-edit',
            'user-delete',
            'request-list',
            'request-create',
            'request-edit',
            'request-delete',
            'employee-list',
            'employee-create',
            'employee-edit',
            'employee-delete',
            'agency-list',
            'agency-create',
            'agency-edit',
            'agency-delete',
        ]);
     
        $user->assignRole([$role->id]);

        $user = User::create([
            "name" => "Bishoples",
            "email" => "bishoples@gmail.com",
            "password" => Hash::make("12345678"),
            "email_verified_at" => Carbon::now()->timestamp,
             "approved"    => "Approved",
        ]);

        $role = Role::create(['name' => 'admin']);

        $role->givePermissionTo([
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'inspector-list',
            'inspector-create',
            'inspector-edit',
            'inspector-delete',
            'inspection-list',
            'inspection-create',
            'inspection-edit',
            'inspection-delete',
            'sendinvoice-list',
            'sendinvoice-create',
            'sendinvoice-edit',
            'sendinvoice-delete',
            'user-list',
            // 'user-create',
            'user-edit',
            'user-delete',
            'request-list',
            'request-create',
            'request-edit',
            'request-delete',
            'employee-list',
            'employee-create',
            'employee-edit',
            'employee-delete',
            'agency-list',
            'agency-create',
            'agency-edit',
            'agency-delete',
        ]);
        
        // $permissions = Permission::pluck('id','id')->all();
   
        // $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
        $user = User::create([
            "name" => "inspector",
            "email" => "testinspector@gmail.com",
            "password" => Hash::make("12345678"),
            "email_verified_at" => Carbon::now()->timestamp,
            "approved"    => "Approved",
        ]);
        $role = Role::create(['name' => 'inspector']);
        $user->assignRole([$role->id]);
        
        $user = User::create([
            "name" => "company",
            "email" => "testcompany@gmail.com",
            "company_name" => "Wind Mitigation",
            "email_verified_at" => Carbon::now()->timestamp,
            "password" => Hash::make("12345678"),
            "approved"    => "Approved",
        ]);
        $role = Role::create(['name' => 'company']);
        $role->givePermissionTo(['request-create','request-list','employee-list','employee-create','employee-edit','employee-delete']);
        $user->assignRole([$role->id]);
        $role = Role::create(['name' => 'employee']);
    }
}
