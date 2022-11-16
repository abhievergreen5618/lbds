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
        Schema::create('email_models', function (Blueprint $table) {
            $table->id();
            $table->string("requestid");
            $table->string("mailto")->nullable();
            $table->string("subject")->nullable();
            $table->string("message")->nullable();
            $table->string("files")->nullable();
            $table->string("attachments")->nullable();
            $table->string("status");
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
        Schema::dropIfExists('email_models');
    }
};
