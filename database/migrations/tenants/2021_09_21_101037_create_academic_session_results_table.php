<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicSessionResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_session_results', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('class_arm');
            $table->uuid('student_id');
            $table->string('class_position');
            $table->string('total_mark_attainable');
            $table->string('total_mark_obtained');
            $table->json('subjects');
            $table->json('ca_format');
            $table->json('grading_format');
            $table->uuid('academic_session_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_arm')
                ->on('class_arms')
                ->references('uuid');

            $table->foreign('student_id')
                ->on('students')
                ->references('uuid');

            $table->foreign('academic_session_id')
                ->on('academic_sessions')
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
        Schema::dropIfExists('academic_session_results');
    }
}
