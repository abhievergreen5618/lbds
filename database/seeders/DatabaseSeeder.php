<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CreateAdminUserSeeder;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\InspectionSeeder;
use Database\Seeders\SendInvoiceSeeder;
use Database\Seeders\OptionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            UserSeeder::class,
            InspectionSeeder::class,
            SendInvoiceSeeder::class,
            OptionsSeeder::class,
        ]);
    }
}
