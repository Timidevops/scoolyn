<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassArmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_arms', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('class_teacher')->nullable();
            $table->json('students')->nullable();
            $table->string('school_class_id');
            $table->string('class_section_id')->nullable();
            $table->string('class_section_category_id')->nullable();
            $table->uuid('academic_session_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_class_id')
                ->on('school_classes')
                ->references('uuid')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

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
        Schema::dropIfExists('class_arms');
    }
}
