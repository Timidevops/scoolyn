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
            $table->string('class_subject_id');
            $table->string('class_arm');
            $table->json('meta');
            $table->string('academic_session_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_subject_id')
                ->on('class_subjects')
                ->references('uuid');

            $table->foreign('class_arm')
                ->on('class_arms')
                ->references('uuid')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('academic_session_id')
                ->on('academic_sessions')
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
        Schema::dropIfExists('academic_broad_sheets');
    }
}
