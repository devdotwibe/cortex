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
        Schema::table('banners', function (Blueprint $table) {
            $table->string('exceltitle')->nullable();
            $table->string('excelsubtitle')->nullable();
            $table->string('subtitle1')->nullable();
            $table->string('subtitle2')->nullable();
            $table->string('subtitle3')->nullable();
            $table->string('excelbuttonlabel')->nullable();
            $table->string('excelbuttonlink')->nullable();
            $table->string('excelimage')->nullable();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn([
                'exceltitle',
                'excelsubtitle',
                'subtitle1',
                'subtitle2',
                'subtitle3',
                'excelbuttonlabel',
                'excelbuttonlink',
                'excelimage'
            ]);
        });
    }

};
