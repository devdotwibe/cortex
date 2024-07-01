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
        Schema::table('setnames', function (Blueprint $table) {
            $table->string('time_of_exam')->default('');
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->string('time_of_exam')->default('');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string('time_of_exam')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setnames', function (Blueprint $table) {
            //
        });
    }
};
