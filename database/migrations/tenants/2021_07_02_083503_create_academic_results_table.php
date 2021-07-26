<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_results', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('class_arm');
            $table->string('student_id');
            $table->string('class_position');
            $table->string('total_mark_attainable');
            $table->string('total_mark_obtained');
            $table->json('subjects');
            $table->json('ca_format')->nullable();
            $table->json('grading_format')->nullable();
            $table->string('academic_session_id');
            $table->string('academic_term_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('academic_session_id')
                ->on('academic_sessions')
                ->references('uuid')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('academic_term_id')
                ->on('academic_terms')
                ->references('uuid')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_results');
    }
}
