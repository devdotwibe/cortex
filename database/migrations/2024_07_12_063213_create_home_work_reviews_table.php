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
        Schema::create('home_work_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('progress')->nullable();
            $table->string('user_id')->nullable();
            $table->foreignIdFor(HomeWork::class)->nullable();
            $table->foreignIdFor(HomeWorkBook::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_work_reviews');
    }
};
