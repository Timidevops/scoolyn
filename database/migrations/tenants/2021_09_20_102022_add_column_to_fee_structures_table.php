<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToFeeStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_structures', function (Blueprint $table) {
            $table->uuid('school_fees_id')->nullable()->after('amount');
            $table->foreign('school_fees_id')->references('uuid')->on('school_fees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_structures', function (Blueprint $table) {
            //
        });
    }
}
