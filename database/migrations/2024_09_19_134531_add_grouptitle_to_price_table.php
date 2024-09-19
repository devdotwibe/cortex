<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pricings', function (Blueprint $table) {
            $table->text('grouptitle')->nullable(); // Add 'grouptitle' column, allowing null values
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price', function (Blueprint $table) {
            //
        });
    }
};
