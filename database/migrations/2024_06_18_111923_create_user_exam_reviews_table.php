<?php

use App\Models\Category;
use App\Models\Exam;
use App\Models\SubCategory;
use App\Models\User;
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
        Schema::create('user_exam_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string("slug");
            $table->foreignIdFor(Exam::class);
            $table->string("title"); 
            $table->string("name"); 
            $table->string("progress")->nullable();  
            $table->foreignIdFor(SubCategory::class)->nullable();
            $table->foreignIdFor(Category::class)->nullable();
            $table->string('sub_category_set')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exam_reviews');
    }
};
