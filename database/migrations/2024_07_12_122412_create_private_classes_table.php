<?php

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
        Schema::create('private_classes', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('email');
            $table->string('full_name')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('timeslot')->nullable();
            $table->string('status')->default('pending');
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_classes');
    }
};
