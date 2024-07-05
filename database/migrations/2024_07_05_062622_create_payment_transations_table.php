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
        Schema::create('payment_transations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('stype')->default('subscribe');
            $table->integer('user_id')->nullable();
            $table->string('status')->default('pending');
            $table->text('content')->nullable();
            $table->text('amount')->default('0'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transations');
    }
};
