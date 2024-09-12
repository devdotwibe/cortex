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
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('combo_amount')->nullable();
            $table->string('basic_amount')->nullable();
            $table->text('content')->nullable();
            $table->text('icon')->nullable();
            $table->string('combo_amount_id')->nullable();
            $table->string('basic_amount_id')->nullable();
            $table->dropColumn(['amount','stripe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(['title','content','icon','combo_amount','basic_amount','basic_amount_id','combo_amount_id']);
            $table->string( 'stripe_id')->nullable();
            $table->string('amount')->default('0');
        });
    }
};
