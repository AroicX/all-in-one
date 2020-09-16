<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->timestamps();
            $table->integer('employee_id');
            $table->string('allowances');
            $table->string('currency_type');
            $table->string('wages_type');
            $table->string('payment_mode');
            $table->string('bank_name');
            $table->string('basic_salary');
            $table->string('bank_acc_no');
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
        Schema::dropIfExists('employee_salaries');
    }
}
