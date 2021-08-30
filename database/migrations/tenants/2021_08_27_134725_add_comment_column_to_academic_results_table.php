<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentColumnToAcademicResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academic_results', function (Blueprint $table) {
            $table->string('comment')->nullable();
            $table->string('principal_remark')->nullable();
            //$table->string('')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academic_results', function (Blueprint $table) {
            //
        });
    }
}
