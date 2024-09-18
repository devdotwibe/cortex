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
        Schema::table('user_review_questions', function (Blueprint $table) {            
            $table->text('title_text')->nullable();
            $table->text('sub_question')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_review_questions', function (Blueprint $table) {
            $table->dropColumn(['title_text','sub_question']);
        });
    }
};
