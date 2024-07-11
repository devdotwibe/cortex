<?php

use App\Models\HomeWork;
use App\Models\HomeWorkBook;
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
        Schema::create('home_work_questions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string("title")->nullable();
            $table->string("duration")->nullable();
            $table->text("description")->nullable();
            $table->text('explanation')->nullable();
            $table->string('visible_status')->default('show');
            $table->foreignIdFor(HomeWork::class); 
            $table->foreignIdFor(HomeWorkBook::class); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_work_questions');
    }
};
