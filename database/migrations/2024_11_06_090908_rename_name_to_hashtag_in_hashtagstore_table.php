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
        Schema::table('hashtagstore', function (Blueprint $table) {
            $table->renameColumn('name', 'hashtag'); // Renames the column from 'name' to 'hashtag'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hashtagstore', function (Blueprint $table) {
            //
        });
    }
};
