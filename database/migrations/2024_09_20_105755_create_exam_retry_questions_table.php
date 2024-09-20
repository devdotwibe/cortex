<?php

use App\Models\Category;
use App\Models\Exam;
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
        Schema::create('exam_retry_questions', function (Blueprint $table) {
            $table->id(); 
            $table->string("slug")->unique();
            $table->string('title')->nullable();
            $table->string('review_type')->nullable();
            $table->text('note')->nullable();
            $table->text('explanation')->nullable();
            $table->text('currect_answer')->nullable();
            $table->text('user_answer')->nullable();
            $table->string('duration')->nullable();
            $table->string('takenduration')->nullable();  
            $table->string('time_taken')->default('0'); 
            $table->text('title_text')->nullable();
            $table->text('sub_question')->nullable(); 
            $table->string('sub_category_set')->nullable();
            $table->foreignIdFor(User::class)->nullable(); 
            $table->foreignIdFor(Exam::class)->nullable();
            $table->foreignIdFor(Question::class)->nullable();
            $table->foreignIdFor(Category::class)->nullable();
            $table->foreignIdFor(SubCategory::class)->nullable(); 
            $table->foreignIdFor(UserExamReview::class)->nullable();
            $table->foreignIdFor(ExamRetryReview::class); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_retry_questions');
    }
};
