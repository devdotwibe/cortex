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
        Schema::create('tab_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('tab_id_1')->nullable();
            $table->string('tab_name_1')->nullable();
            $table->string('tab_sort_1')->nullable();

            $table->string('tab_id_2')->nullable();
            $table->string('tab_name_2')->nullable();
            $table->string('tab_sort_2')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_orders');
    }
};
