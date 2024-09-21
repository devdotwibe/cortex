<?php

use App\Models\Answer;
use App\Models\Category;
use App\Models\Exam;
use App\Models\ExamRetryQuestion;
use App\Models\ExamRetryReview;
use App\Models\Question;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserExamReview;
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
        Schema::create('exam_retry_answers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable(); 
            $table->boolean('iscorrect')->default(false);  
            $table->boolean('user_answer')->default(false);
            $table->foreignIdFor(User::class)->nullable(); 
            $table->foreignIdFor(Exam::class)->nullable();
            $table->foreignIdFor(Question::class)->nullable();  
            $table->foreignIdFor(Answer::class)->nullable();  
            $table->foreignIdFor(UserExamReview::class)->nullable();
            $table->foreignIdFor(ExamRetryReview::class)->nullable(); 
            $table->foreignIdFor(ExamRetryQuestion::class)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_retry_answers');
    }
};
