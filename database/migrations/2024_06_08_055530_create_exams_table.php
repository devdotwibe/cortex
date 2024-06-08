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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->text("title")->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text("image")->nullable();
            $table->decimal('price',10,2)->default(0);
            $table->decimal('discount',10,2)->default(0);
            $table->string("status")->default("active");
            $table->boolean("featured")->default(false);
            $table->integer('duration')->nullable();
            $table->string("duration_type")->default("none");
            $table->string('time_of_exam')->default('1 hour');
            $table->text('overview')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
