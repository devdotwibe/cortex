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
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('users')->default('N');
            $table->string('learn')->default('N');
            $table->string('options')->default('N');
            $table->string('question_bank')->default('N');
            $table->string('exam_simulator')->default('N');
            $table->string('live_teaching')->default('N');
            $table->string('community')->default('N');
            $table->string('pages')->default('N');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_permissions');
    }
};
