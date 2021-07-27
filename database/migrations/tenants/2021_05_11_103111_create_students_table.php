<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('matriculation_number')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_name');
            $table->string('gender');
            $table->string('dob');
            $table->string('address');
            $table->string('class_arm');
            $table->string('parent_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')
                ->on('parents')
                ->references('uuid')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('class_arm')
                ->on('class_arms')
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
        Schema::dropIfExists('students');
    }
}
