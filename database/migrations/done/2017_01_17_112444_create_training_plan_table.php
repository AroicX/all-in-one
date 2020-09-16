<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_training_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('title');
            $table->string('grade');
            $table->string('department');
            $table->string('facilitator');
            $table->string('venue_time');
            $table->string('training_budget');
            $table->string('branch');
            $table->string('designation');
            $table->string('objectives');
            $table->string('training_type');
            $table->string('mode_of_delivery');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_plan');
    }
}
