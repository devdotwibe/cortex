<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('guaranteetitle')->nullable();
            $table->string('learntitle')->nullable();
            $table->string('learnimage')->nullable();
            $table->text('learncontent')->nullable();
            $table->string('practisetitle')->nullable();
            $table->string('practiseimage')->nullable();
            $table->text('practisecontent')->nullable();
            $table->string('preparetitle')->nullable();
            $table->string('prepareimage')->nullable();
            $table->text('preparecontent')->nullable();
            $table->string('reviewtitle')->nullable();
            $table->string('reviewimage')->nullable();
            $table->text('reviewcontent')->nullable();
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
                'guaranteetitle',
                'learntitle',
                'learnimage',
                'learncontent',
                'practisetitle',
                'practiseimage',
                'practisecontent',
                'preparetitle',
                'prepareimage',
                'preparecontent',
                'reviewtitle',
                'reviewimage',
                'reviewcontent',
            ]);
        });
    }
};
