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
        Schema::create('coupon_offers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name')->nullable();
            $table->string('amount')->nullable();
            $table->string('expire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_offers');
    }
};
