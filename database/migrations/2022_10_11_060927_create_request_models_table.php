<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_models', function (Blueprint $table) {
            $table->id();
            $table->string('company_id')->nullable();
            $table->string('inspectiontype')->nullable();
            $table->string('applicantname')->nullable();
            $table->string('applicantemail')->nullable();
            $table->string('applicantmobile')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('comments')->nullable();
            $table->string('sendinvoice')->nullable();
            $table->string('status')->default("pending");
            $table->string('agency_related_files')->nullable();
            $table->string('reports_related_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_models');
    }
};
