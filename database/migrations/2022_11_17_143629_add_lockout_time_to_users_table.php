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
        // Up
        Schema::table('users', function (Blueprint $table) {
            $table->integer('lockout_time')->default(30)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Down
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('lockout_time');
        });
    }
};
