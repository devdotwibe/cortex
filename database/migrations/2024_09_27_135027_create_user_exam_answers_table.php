<?php

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use App\Models\UserExam;
use App\Models\UserExamQuestion;
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
        Schema::create('user_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->foreignIdFor(UserExam::class);
            $table->foreignIdFor(UserExamQuestion::class);
            $table->foreignIdFor(Question::class);
            $table->foreignIdFor(Answer::class);
            $table->foreignIdFor(Exam::class);
            $table->foreignIdFor(User::class);
            $table->boolean('iscorrect')->default(false);
            $table->boolean('user_answer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exam_answers');
    }
};
