<?php

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
        Schema::create('live_class_pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->string('class_title_1')->nullable();
            $table->text('class_description_1')->nullable();
            $table->text('class_image_1')->nullable();

            $table->string('class_title_2')->nullable();
            $table->text('class_description_2')->nullable();
            $table->text('class_image_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_class_pages');
    }
};
