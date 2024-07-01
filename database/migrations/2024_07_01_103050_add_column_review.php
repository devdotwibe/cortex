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
            $table->integer('question_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('exam_id')->nullable();
            $table->string('time_taken')->default('0');
        });
        Schema::table('user_review_answers', function (Blueprint $table) {
            $table->integer('exam_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('question_id')->nullable();
            $table->integer('answer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_review_questions', function (Blueprint $table) {
            $table->dropColumn(['user_id','exam_id','question_id','time_taken']); 
        });
        Schema::table('user_review_answers', function (Blueprint $table) {
            $table->dropColumn(['user_id','exam_id','question_id','answer_id']); 
        });
    }
};
