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
         Schema::table('maincourse', function (Blueprint $table) {
             $table->text('learncontent')->nullable();
             $table->string('learnimage')->nullable();
             $table->text('questionbankcontent')->nullable();
             $table->string('questionbankimage')->nullable();
             $table->text('topiccontent')->nullable();
             $table->string('topicimage')->nullable();
             $table->text('fullmockcontent')->nullable();
             $table->string('fullmockimage')->nullable();
             $table->text('privatecontent')->nullable();
             $table->string('privateimage')->nullable();
         });
     }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('maincourse', function (Blueprint $table) {
            $table->dropColumn(['learncontent', 'learnimage', 'questionbankcontent', 'questionbankimage', 'topiccontent', 'topicimage', 'fullmockcontent', 'fullmockimage', 'privatecontent', 'privateimage']);
        });
    }
};
