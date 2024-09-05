<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMaincourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maincourse', function (Blueprint $table) {
            // Add new columns to the table
            $table->string('coursetitle')->nullable();
            $table->string('coursesubtitle')->nullable();
            $table->string('logicaltitle1')->nullable();
            $table->string('logicaltitle2')->nullable();
            $table->text('logicalcontent')->nullable();
            $table->string('logicalimage')->nullable();
            $table->string('criticaltitle1')->nullable();
            $table->string('criticaltitle2')->nullable();
            $table->text('criticalcontent')->nullable();
            $table->string('criticalimage')->nullable();
            $table->string('abstracttitle1')->nullable();
            $table->string('abstracttitle2')->nullable();
            $table->text('abstractcontent')->nullable();
            $table->string('abstractimage')->nullable();
            $table->string('numericaltitle1')->nullable();
            $table->string('numericaltitle2')->nullable();
            $table->text('numericalcontent')->nullable();
            $table->string('numericalimage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maincourse', function (Blueprint $table) {
            // Drop columns to revert changes
            $table->dropColumn([
                'coursetitle',
                'coursesubtitle',
                'logicaltitle1',
                'logicaltitle2',
                'logicalcontent',
                'logicalimage',
                'criticaltitle1',
                'criticaltitle2',
                'criticalcontent',
                'criticalimage',
                'abstracttitle1',
                'abstracttitle2',
                'abstractcontent',
                'abstractimage',
                'numericaltitle1',
                'numericaltitle2',
                'numericalcontent',
                'numericalimage',
            ]);
        });
    }
}
