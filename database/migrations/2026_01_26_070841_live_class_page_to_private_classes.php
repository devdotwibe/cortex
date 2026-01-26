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
        Schema::table('private_classes', function (Blueprint $table) {

            $table->json('timeslot_ids')->nullable()->after('timeslot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('private_classes', function (Blueprint $table) {

             $table->dropColumn('timeslot_ids');
        });
    }
};
