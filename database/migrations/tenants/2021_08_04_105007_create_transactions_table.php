<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('school_fees_id');
            $table->string('user_id');
            $table->string('reference');
            $table->string('type');
            $table->string('payment_method_reference')->nullable();
            $table->float('amount',18);
            $table->string('description')->nullable();
            $table->float('fees', 18)->nullable();
            $table->string('currency');
            $table->string('academic_session_id');
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('school_fees_id')
//                ->on('school_fees')
//                ->references('uuid');
//               // ->cascadeOnDelete();
//
//            $table->foreign('user_id')
//                ->on('users')
//                ->references('uuid');
//               // ->cascadeOnUpdate()
//               // ->cascadeOnDelete();

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
        Schema::dropIfExists('transactions');
    }
}
