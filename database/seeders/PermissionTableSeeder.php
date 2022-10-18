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
            'sendinvoice-list',
            'sendinvoice-create',
            'sendinvoice-edit',
            'sendinvoice-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
