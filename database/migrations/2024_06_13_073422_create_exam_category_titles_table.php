<?php

use App\Models\Category;
use App\Models\Exam;
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
        Schema::create('exam_category_titles', function (Blueprint $table) {
            $table->id();
            $table->string("slug");
            $table->string("title");
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(Exam::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_category_titles');
    }
};
