<?php

use App\Models\Learn;
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
        Schema::create('learn_answers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->timestamps();
            $table->string('mcq_answer')->nullable();

            $table->foreignIdFor(Learn::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learn_answers');
    }
};
