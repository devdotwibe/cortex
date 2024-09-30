<?php

use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserExam;
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
        Schema::create('user_exam_questions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->test('description')->nullable();
            $table->string('duration')->nullable();
            $table->foreignIdFor(Exam::class);
            $table->foreignIdFor( UserExam::class);
            $table->foreignIdFor(Category::class)->nullable();
            $table->foreignIdFor(SubCategory::class)->nullable(); 
            $table->unsignedInteger('sub_category_set')->nullable();
            $table->foreignIdFor(Question::class);
            $table->foreignIdFor(User::class);
            $table->text('explanation')->nullable();
            $table->string('visible_status')->default('show');
            $table->text('title_text')->nullable();
            $table->text('sub_question')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exam_questions');
    }
};
