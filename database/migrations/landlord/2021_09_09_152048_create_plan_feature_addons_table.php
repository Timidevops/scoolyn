<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanFeatureAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_feature_addons', function (Blueprint $table) {
            $table->id();
            $table->string('feature_addon_id');
            $table->string('subscriber_id');
            $table->string('value');
            $table->string('value_left');
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('feature_addon_id')
//                ->on('feature_addons')
//                ->references('uuid');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_feature_addons');
    }
}
