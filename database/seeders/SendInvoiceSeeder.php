<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SendInvoice;

class SendInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SendInvoice::create([
            "name" => "Homeowner",
            "description" => "test",
        ]);
        SendInvoice::create([
            "name" => "Requester",
            "description" => "test",
        ]);
    }
}
