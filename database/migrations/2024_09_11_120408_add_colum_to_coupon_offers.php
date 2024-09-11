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
        Schema::table('coupon_offers', function (Blueprint $table) {
            $table->string('visible_status')->default('show');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_offers', function (Blueprint $table) {
            $table->dropColumn('visible_status');
        });
    }
};
