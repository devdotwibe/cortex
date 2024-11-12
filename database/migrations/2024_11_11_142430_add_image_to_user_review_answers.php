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
        Schema::table('user_review_answers', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });
        Schema::table('user_exam_answers', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });
        Schema::table('exam_retry_answers', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });
        Schema::table('learn_answers', function (Blueprint $table) {
            $table->string('image')->nullable()->after('title');
        });
        Schema::table('home_work_answers', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });
        Schema::table('home_work_review_answers', function (Blueprint $table) {
            $table->string('image')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_review_answers', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('user_exam_answers', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('exam_retry_answers', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('learn_answers', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('home_work_answers', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('home_work_review_answers', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
