<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inspectiontype;

class InspectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inspectiontype::create([
            "name" => "Wind Mitigation Inspection",
            "description" => "test",
        ]);
        Inspectiontype::create([
            "name" => "4 Point Insurance Inspection",
            "description" => "test",
        ]);
        Inspectiontype::create([
            "name" => "Roof Condition Inspection",
            "description" => "test",
        ]);
        Inspectiontype::create([
            "name" => "Roof to Wall Affidavit",
            "description" => "test",
        ]);
        Inspectiontype::create([
            "name" => "Individual Owner Units",
            "description" => "test",
        ]);
        Inspectiontype::create([
            "name" => "Master Wind Mitigation",
            "description" => "test",
        ]);
    }
}
