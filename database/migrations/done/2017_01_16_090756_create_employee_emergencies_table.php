<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEmergenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_emergencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->timestamps();
            $table->integer('employee_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('relationship');
            $table->string('mobile_number');
            $table->string('phone_number');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_emergencies');
    }
}
