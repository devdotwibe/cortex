<?php

use App\Models\Category;
use App\Models\Exam;
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
        Schema::create('exam_retry_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string("progress")->nullable(); 
            $table->string('timetaken')->nullable();
            $table->string('passed')->nullable();
            $table->string('time_of_exam')->nullable();
            $table->text('flags')->nullable();
            $table->text('times')->nullable();
            $table->text('questions')->nullable();
            $table->string('sub_category_set')->nullable();
            $table->foreignIdFor(User::class); 
            $table->foreignIdFor(Exam::class)->nullable();
            $table->foreignIdFor(Category::class)->nullable();
            $table->foreignIdFor(SubCategory::class)->nullable(); 
            $table->foreignIdFor(UserExamReview::class); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_retry_reviews');
    }
};
