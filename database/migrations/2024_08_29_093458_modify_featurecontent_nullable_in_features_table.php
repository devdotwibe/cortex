<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFeaturecontentNullableInFeaturesTable extends Migration
{
    public function up()
    {
        Schema::table('features', function (Blueprint $table) {
            $table->text('featurecontent')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('features', function (Blueprint $table) {
            $table->text('featurecontent')->nullable(false)->change();
        });
    }
}
