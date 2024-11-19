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
        Schema::table('exam_retry_questions', function (Blueprint $table) {
            $table->longText('note')->nullable()->change();
            $table->longText('explanation')->nullable()->change();
            $table->longText('title_text')->nullable()->change();
            $table->longText('sub_question')->nullable()->change();
        });
        Schema::table('home_work_questions', function (Blueprint $table) {
            $table->longText('description')->nullable()->change();
            $table->longText('explanation')->nullable()->change();
            $table->longText('title')->nullable()->change();
        });
        Schema::table('home_work_review_questions', function (Blueprint $table) {
            $table->longText('note')->nullable()->change();
            $table->longText('explanation')->nullable()->change();
            $table->longText('title')->nullable()->change();
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->longText('description')->nullable()->change();
            $table->longText('explanation')->nullable()->change();
            $table->longText('title_text')->nullable()->change();
            $table->longText('sub_question')->nullable()->change();
        });
        Schema::table('user_exam_questions', function (Blueprint $table) {
            $table->longText('description')->nullable()->change();
            $table->longText('explanation')->nullable()->change();
            $table->longText('title_text')->nullable()->change();
            $table->longText('sub_question')->nullable()->change();
        });
        Schema::table('user_review_questions', function (Blueprint $table) {
            $table->longText('note')->nullable()->change();
            $table->longText('explanation')->nullable()->change();
            $table->longText('title_text')->nullable()->change();
            $table->longText('sub_question')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_retry_questions', function (Blueprint $table) {
            $table->text('note')->nullable()->change();
            $table->text('explanation')->nullable()->change();
            $table->text('title_text')->nullable()->change();
            $table->text('sub_question')->nullable()->change();
        });
        Schema::table('home_work_questions', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('explanation')->nullable()->change();
            $table->text('title')->nullable()->change();
        });
        Schema::table('home_work_review_questions', function (Blueprint $table) {
            $table->text('note')->nullable()->change();
            $table->text('explanation')->nullable()->change();
            $table->text('title')->nullable()->change();
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->text('explanation')->nullable()->change();
            $table->text('title_text')->nullable()->change();
            $table->text('sub_question')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
        Schema::table('user_exam_questions', function (Blueprint $table) {
            $table->text('explanation')->nullable()->change();
            $table->text('title_text')->nullable()->change();
            $table->text('sub_question')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
        Schema::table('user_review_questions', function (Blueprint $table) {
            $table->text('note')->nullable()->change();
            $table->text('explanation')->nullable()->change();
            $table->text('title_text')->nullable()->change();
            $table->text('sub_question')->nullable()->change();
        });
    }
};
