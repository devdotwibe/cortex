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
        Schema::table('user_exam_questions', function (Blueprint $table) {
            $table->bigInteger('order_no')->default(9999999999);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_exam_questions', function (Blueprint $table) {
            $table->dropColumn('order_no');
        });
    }
};
