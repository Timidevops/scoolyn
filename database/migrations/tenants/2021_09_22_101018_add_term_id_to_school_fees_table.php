<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermIdToSchoolFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_fees', function (Blueprint $table) {
            $table->uuid('term_id')->after('academic_session_id')->nullable();
            $table->foreign('term_id')->references('uuid')->on('academic_terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_fees', function (Blueprint $table) {
            //
        });
    }
}
