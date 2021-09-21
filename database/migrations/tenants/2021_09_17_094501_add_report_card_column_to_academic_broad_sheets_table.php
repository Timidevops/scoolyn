<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportCardColumnToAcademicBroadSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academic_broad_sheets', function (Blueprint $table) {
            $table->uuid('report_card')->nullable()->after('academic_session_id');

            $table->foreign('report_card')
                ->on('report_card_breakdown_formats')
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
        Schema::table('academic_broad_sheets', function (Blueprint $table) {
            //
        });
    }
}
