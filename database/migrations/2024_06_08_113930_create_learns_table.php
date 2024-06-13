<?php

use App\Models\Category;
use App\Models\SubCategory;
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
        Schema::create('learns', function (Blueprint $table) {
            $table->id();
            $table->string("slug");

            $table->string('title')->nullable();

            $table->string('learn_type')->nullable();

            $table->string('video_url')->nullable();

            $table->text('short_question')->nullable();

            $table->text('short_answer')->nullable();

            $table->text('mcq_question')->nullable();

            $table->foreignIdFor(SubCategory::class);
            $table->foreignIdFor(Category::class);



            $table->timestamps();
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learns');
    }
};
