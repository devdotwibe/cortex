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
            $table->text('exceltitle')->nullable();
            $table->string('excelbuttonlabel')->nullable();
            $table->string('excelbuttonlink')->nullable();
            $table->string('excelimage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricings', function (Blueprint $table) {
            //
        });
    }
};
