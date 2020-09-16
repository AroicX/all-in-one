<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('company_id');
            $table->string('surname');
            $table->string('middlename');
            $table->string('firstname');
            $table->string('title');
            $table->string('employee_code');
            $table->string('designation');
            $table->string('grade');
            $table->string('department');
            $table->string('category');
            $table->string('join_date');
            $table->string('branch');
            $table->string('file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_profiles');
    }
}
