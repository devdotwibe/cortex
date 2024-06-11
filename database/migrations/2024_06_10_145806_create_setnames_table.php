<?php

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
        Schema::create('setnames', function (Blueprint $table) {
            $table->id();
            $table->string("slug");
            $table->string('name')->nullble();
            $table->foreignIdFor(SubCategory::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setnames');
    }
};
