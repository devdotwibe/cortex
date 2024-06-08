<?php

use App\Models\QuestionBankChapter;
use App\Models\QuestionBankTopic;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_bank_sections', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("slug");
            $table->foreignIdFor(QuestionBankChapter::class);
            $table->foreignIdFor(QuestionBankTopic::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_bank_sections');
    }
};
