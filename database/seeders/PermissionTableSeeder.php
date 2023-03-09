<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
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
            'invoicetype-list',
            'invoicetype-create',
            'invoicetype-edit',
            'invoicetype-delete',
            'user-list',
            'user-create',
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
            'job-calendar',
            'payroll-tracker',
            'email-logs',
            'portal-settings',
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
