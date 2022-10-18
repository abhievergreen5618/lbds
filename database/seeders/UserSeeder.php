<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
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
        // User::create([
        //     "name" => "admin",
        //     "email" => "testadmin@gmail.com",
        //     "password" => Hash::make("12345678"),
        //     "email_verified_at" => Carbon::now()->timestamp,
        //     "role" => "1",
        // ]);
        User::create([
            "name" => "Bishoples",
            "email" => "bishoples@gmail.com",
            "password" => Hash::make("12345678"),
            // "email_verified_at" => Carbon::now()->timestamp,
            "role" => "1",
        ]);
        User::create([
            "name" => "inspector",
            "email" => "abhishek@evergreenbrain.com",
            "password" => Hash::make("12345678"),
            // "email_verified_at" => Carbon::now()->timestamp,
            "role" => "2",
        ]);
        User::create([
            "name" => "company",
            "email" => "testcompany@gmail.com",
            "company_name" => "Wind Mitigation",
            // "email_verified_at" => Carbon::now()->timestamp,
            "password" => Hash::make("12345678"),
            "role" => "3",
        ]);
    }
}
