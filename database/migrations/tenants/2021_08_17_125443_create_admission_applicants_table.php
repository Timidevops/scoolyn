<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_applicants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('student_first_name');
            $table->string('student_last_name');
            $table->string('student_other_name');
            $table->string('student_dob');
            $table->string('student_gender');
            $table->string('student_religion');
            $table->string('student_blood_group')->nullable();
            $table->string('student_address');
            $table->string('class');
            $table->string('section')->nullable();
            $table->string('previous_school');
            $table->string('previous_class');
            $table->string('guardian_name');
            $table->string('guardian_contact_number');
            $table->string('guardian_contact_email')->nullable();
            $table->string('guardian_address');
            $table->string('guardian_relationship');
            $table->string('guardian_profession')->nullable();
            $table->text('extra_information')->nullable();
            $table->string('academic_session_id');
            $table->string('academic_term_id');
            $table->string('status');
            $table->dateTime('exam_schedule')->nullable();
            $table->string('passport');
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
        Schema::dropIfExists('admission_applicants');
    }
}
