<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_loan_master', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('loan_name');
            $table->string('loan_maximum_limit');
            $table->string('loan_limit_annual_gross');
            $table->integer('multiple_loan');
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
        Schema::dropIfExists('hrm_loan_master');
    }
}
