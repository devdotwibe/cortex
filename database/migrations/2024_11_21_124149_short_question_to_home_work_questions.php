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
        Schema::table('home_work_questions', function (Blueprint $table) {

            $table->longText('short_question')->nullable();
            $table->longText('short_answer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_work_questions', function (Blueprint $table) {
            $table->dropColumn('short_question');
            $table->dropColumn('short_answer');
        });
    }
};
