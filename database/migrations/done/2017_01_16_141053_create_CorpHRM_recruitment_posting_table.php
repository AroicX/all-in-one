<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpHRMRecruitmentPostingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpHRM_recruitment_posting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id');
            $table->string('job_title');
            $table->string('job_code');
            $table->text('job_description');
            $table->string('posted_date');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('location');
            $table->integer('no_of_vacancies');
            $table->integer('years_of_experience');
            $table->text('qualification_details');
            $table->text('experience_details');
            $table->text('other_details');
            $table->string('email');
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
        Schema::dropIfExists('corpHRM_recruitment_posting');
    }
}
