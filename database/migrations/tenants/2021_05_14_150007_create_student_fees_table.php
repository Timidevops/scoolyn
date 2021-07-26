<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('student_id');
            $table->json('fee_structure_id');
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
        Schema::dropIfExists('student_fees');
    }
}
