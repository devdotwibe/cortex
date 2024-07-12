<?php

use App\Models\HomeWork;
use App\Models\HomeWorkAnswer;
use App\Models\HomeWorkBook;
use App\Models\HomeWorkQuestion;
use App\Models\HomeWorkReview;
use App\Models\HomeWorkReviewQuestion;
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
        Schema::create('home_work_review_answers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->boolean('iscorrect')->default(false);
            $table->boolean('user_answer')->default(false);
            $table->foreignIdFor(HomeWork::class)->nullable();
            $table->foreignIdFor(HomeWorkBook::class)->nullable();
            $table->foreignIdFor(HomeWorkQuestion::class)->nullable();
            $table->foreignIdFor(HomeWorkAnswer::class)->nullable();
            $table->foreignIdFor(HomeWorkReview::class)->nullable();
            $table->foreignIdFor(HomeWorkReviewQuestion::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_work_review_answers');
    }
};
