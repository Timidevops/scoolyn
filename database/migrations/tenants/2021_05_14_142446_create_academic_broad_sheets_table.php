<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicBroadSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_broad_sheets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->morphs('schoolClass');
            $table->string('subject_id');
            $table->string('teacher_id');
            $table->json('meta');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_broad_sheets');
    }
}
