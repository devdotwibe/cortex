<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_exam_reviews', function (Blueprint $table) {
            $table->string('timed')->nullable();
            $table->string('timetaken')->nullable();
            $table->text('flags')->nullable();
            $table->text('times')->nullable();
            $table->string('passed')->nullable();
            $table->string('time_of_exam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_exam_reviews', function (Blueprint $table) {
            $table->dropColumn(['timed','timetaken','flags','times','passed','time_of_exam']);
        });
    }
};
