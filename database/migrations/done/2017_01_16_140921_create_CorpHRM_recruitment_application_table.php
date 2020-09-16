<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpHRMRecruitmentApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpHRM_recruitment_application', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('job_title');
            $table->string('employee_name');
            $table->string('posted_date');
            $table->string('branch');
            $table->string('designation');
            $table->string('department');
            $table->string('category');
            $table->text('job_description');
            $table->text('qualification_details');
            $table->text('experience_details');
            $table->text('skill_details');
            $table->integer('no_of_vacancies');
            $table->string('status');
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
        Schema::dropIfExists('corpHRM_recruitment_application');
    }
}
