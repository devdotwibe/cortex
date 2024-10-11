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
        Schema::create('timetable', function (Blueprint $table) {
            $table->id();
            $table->string('starttime'); // Store start time (e.g., '09:30 AM')
            $table->string('endtime');   // Store end time (e.g., '11:30 AM')
            $table->string('day');       // Store the day (e.g., 'Saturday')
            $table->string('classtime'); // Store combined 'starttime - endtime on day'
            $table->integer('count');    // Store the number of users/slots
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetable');
    }
};
