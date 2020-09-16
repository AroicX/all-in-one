<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpHRMRecruitmentProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpHRM_recruitment_process', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('process_name');
            $table->string('process_description');
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
        Schema::dropIfExists('corpHRM_recruitment_process');
    }
}
