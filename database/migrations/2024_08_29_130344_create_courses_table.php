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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('coursetitle')->nullable();
            $table->string('coursesubtitle')->nullable();
            $table->string('courseheading1')->nullable();
            $table->text('coursecontent1')->nullable();
            $table->string('courseheading2')->nullable();
            $table->text('coursecontent2')->nullable();
            $table->string('courseheading3')->nullable();
            $table->text('coursecontent3')->nullable();
            $table->string('courseheading4')->nullable();
            $table->text('coursecontent4')->nullable();
            $table->string('coursebuttonlabel')->nullable();
            $table->string('coursebuttonlink')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
