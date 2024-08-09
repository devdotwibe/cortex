<?php

use App\Models\PollOption;
use App\Models\Post;
use App\Models\User;
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
            $table->string('slug')->unique();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Post::class);
            $table->foreignIdFor(PollOption::class)->nullable();
            $table->timestamps(); 
        });

        Schema::create('poll_options', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignIdFor(Post::class);
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
