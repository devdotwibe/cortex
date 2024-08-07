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
        Schema::table('live_class_pages', function (Blueprint $table) {

            $table->text('private_class')->nullable();

            $table->text('intensive_class')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_class_pages', function (Blueprint $table) {
            $table->dropColumn(['private_class','intensive_class']);
        });
    }
};
