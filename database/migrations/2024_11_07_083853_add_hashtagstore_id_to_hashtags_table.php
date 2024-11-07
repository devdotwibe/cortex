<?php

use App\Models\Hashtagstore;
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
        Schema::table('hashtags', function (Blueprint $table) {
            $table->foreignIdFor(Hashtagstore::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hashtags', function (Blueprint $table) {
            //
        });
    }
};
