<?php

use App\Models\Admin;
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
        Schema::table('learns', function (Blueprint $table) {
            $table->foreignIdFor(Admin::class)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learns', function (Blueprint $table) {
            $table->dropColumn('admin_id');
            $table->dropSoftDeletes();
        });
    }
};
