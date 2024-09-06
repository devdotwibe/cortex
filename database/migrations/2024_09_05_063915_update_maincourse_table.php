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
            // Rename the 'buttontitle' column to 'buttonlink'
            $table->renameColumn('buttontitle', 'buttonlink');

            // Add the new 'image' column (nullable)
            $table->string('image')->nullable();
        });
    }

    public function down()
    {
        Schema::table('maincourse', function (Blueprint $table) {
            // Rollback the 'buttonlink' column name back to 'buttontitle'
            $table->renameColumn('buttonlink', 'buttontitle');

            // Drop the 'image' column
            $table->dropColumn('image');
        });
    }

};
