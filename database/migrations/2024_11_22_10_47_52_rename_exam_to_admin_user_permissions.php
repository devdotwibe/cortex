<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admin_permissions', function (Blueprint $table) {

            $table->renameColumn('exam_simulator', 'topic_exam');
        });

        Schema::table('admin_permissions', function (Blueprint $table) {
            $table->string('full_mock_exam')->default('N');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {

            $table->renameColumn('topic_exam', 'exam_simulator');
            $table->dropColumn('full_mock_exam');

        });
    }
};
