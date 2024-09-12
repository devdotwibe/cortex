<?php

use App\Models\SubscriptionPlan;
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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string( 'stripe_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_status')->default('pending');
            $table->foreignIdFor(User::class);
            $table->string('amount')->default('0');
            $table->foreignIdFor(SubscriptionPlan::class);
            $table->timestamp('expire_at')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
