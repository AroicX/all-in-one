<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingFacilitatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_training_facilitator', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('training_name');
            $table->string('facilitator_name');
            $table->string('contact_person_name');
            $table->string('mobile_no');
            $table->text('address');
            $table->string('facilitator_email');
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
        Schema::dropIfExists('training_facilitator');
    }
}
