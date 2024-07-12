<?php

use App\Models\HomeWork;
use App\Models\HomeWorkBook;
use App\Models\HomeWorkQuestion;
use App\Models\HomeWorkReview;
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
        Schema::create('home_work_review_questions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->string('review_type')->nullable();
            $table->text('note')->nullable();
            $table->text('explanation')->nullable();
            $table->string('currect_answer')->default('');
            $table->string('user_answer')->nullable();
            $table->string('user_id')->nullable();
            $table->string('time_taken')->nullable();
            $table->foreignIdFor(HomeWork::class)->nullable();
            $table->foreignIdFor(HomeWorkBook::class)->nullable();
            $table->foreignIdFor(HomeWorkQuestion::class)->nullable();
            $table->foreignIdFor(HomeWorkReview::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_work_review_questions');
    }
};
