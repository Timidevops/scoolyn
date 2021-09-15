<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarketerIdColumnToSchoolAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_admins', function (Blueprint $table) {

            $table->uuid('marketer_id')->nullable()->after('setup_complete');

            $table->foreign('marketer_id')
                ->on('marketers')
                ->references('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_admins', function (Blueprint $table) {
            //
        });
    }
}
