<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpHRMJobProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpHRM_job_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('job_title');
            $table->string('job_description');
            $table->text('qualification_details');
            $table->text('experience_details');
            $table->text('skill_details');
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
        Schema::dropIfExists('corpHRM_job_profile');
    }
}
