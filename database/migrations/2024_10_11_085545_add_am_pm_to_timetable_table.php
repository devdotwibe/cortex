<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('timetable', function (Blueprint $table) {
            $table->string('starttime_am_pm')->after('starttime')->nullable();
            $table->string('endtime_am_pm')->after('endtime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetable', function (Blueprint $table) {
            //
        });
    }
};
