<?php

use App\Models\Category;
use App\Models\SubCategory;
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
        Schema::create('user_review_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UserExamReview::class)->nullable();
            $table->string("slug");
            $table->string('title')->nullable();
            $table->string('review_type')->nullable();
            $table->text('note')->nullable();
            $table->text('explanation')->nullable();
            $table->text('currect_answer')->nullable();
            $table->text('user_answer')->nullable();
            $table->string('duration')->nullable();
            $table->string('takenduration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_review_questions');
    }
};
