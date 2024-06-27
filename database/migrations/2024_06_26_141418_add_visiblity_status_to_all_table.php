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
        Schema::table('users', function (Blueprint $table) {
            $table->string("visible_status")->default('show');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string("visible_status")->default('show');
        });
        Schema::table('exams', function (Blueprint $table) {
            $table->string("visible_status")->default('show');
        });
        Schema::table('learns', function (Blueprint $table) {
            $table->string("visible_status")->default('show');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->string("visible_status")->default('show');
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->string("visible_status")->default('show');
        });
        Schema::table('setnames', function (Blueprint $table) {
            $table->string("visible_status")->default('show');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("visible_status");
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn("visible_status");
        });
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn("visible_status");
        });
        Schema::table('learns', function (Blueprint $table) {
            $table->dropColumn("visible_status");
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn("visible_status");
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn("visible_status");
        });
        Schema::table('setnames', function (Blueprint $table) {
            $table->dropColumn("visible_status");
        });
    }
};
