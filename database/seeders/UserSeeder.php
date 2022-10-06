<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "admin",
            "email" => "testadmin@gmail.com",
            "password" => Hash::make("12345678"),
            "role" => "1",
        ]);
        User::create([
            "name" => "inspector",
            "email" => "testinspector@gmail.com",
            "password" => Hash::make("12345678"),
            "role" => "2",
        ]);
        User::create([
            "name" => "company",
            "email" => "testcompany@gmail.com",
            "password" => Hash::make("12345678"),
            "role" => "3",
        ]);
    }
}
