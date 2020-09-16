<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_processes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('job_title');
            $table->string('process_name');
            $table->string('from_date');
            $table->string('to_date');
            $table->string('from_time');
            $table->string('to_time');
            $table->string('supervisor');
            $table->string('interview_one');
            $table->string('interview_two');
            $table->string('interview_three');
            $table->string('sorting_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_processes');
    }
}
