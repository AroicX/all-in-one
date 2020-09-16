<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('company_id');
            $table->string('job_title');
            $table->string('process_name');
            $table->string('actual_rate');
            $table->string('minimum_rate');
            $table->string('maximum_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_ratings');
    }
}
