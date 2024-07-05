<?php

use App\Models\ClassDetail;
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
        Schema::create('sub_class_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug');
            $table->string('meeting_id')->nullable();
            $table->string('passcode')->nullable();
            $table->text('zoom_link')->nullable();

            $table->string('date_time')->nullable();
            $table->foreignIdFor(ClassDetail::class);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_class_details');
    }
};
