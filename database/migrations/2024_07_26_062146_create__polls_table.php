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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // Define user_id
            $table->string('question');
            $table->timestamps(); 
        });

        Schema::create('poll_options', function (Blueprint $table) {
            $table->id();
            $table->integer('poll_id'); // Define poll_id
            $table->string('option');
            $table->integer('votes')->default(0);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('poll_options');
        Schema::dropIfExists('polls');
    }
   
    
};
