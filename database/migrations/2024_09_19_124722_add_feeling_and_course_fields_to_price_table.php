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
            $table->text('feelingtitle')->nullable();      // Add 'feelingtitle' as text
            $table->string('feelingimage')->nullable();    // Add 'feelingimage' as string for storing image path
            $table->text('ourcoursetitle')->nullable();    // Add 'ourcoursetitle' as text
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
