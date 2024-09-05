<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('analytics_image')->nullable();
            $table->string('analytics_title')->nullable();
            $table->text('analytics_content')->nullable();
            $table->string('anytime_image')->nullable();
            $table->string('anytime_title')->nullable();
            $table->text('anytime_description')->nullable();
            $table->string('unlimited_image')->nullable();
            $table->string('unlimited_title')->nullable();
            $table->text('unlimited_content')->nullable();
            $table->string('live_image')->nullable();
            $table->string('live_title')->nullable();
            $table->text('live_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn([
                'analytics_image',
                'analytics_title',
                'analytics_content',
                'anytime_image',
                'anytime_title',
                'anytime_description',
                'unlimited_image',
                'unlimited_title',
                'unlimited_content',
                'live_image',
                'live_title',
                'live_content',
            ]);
        });
    }
}
