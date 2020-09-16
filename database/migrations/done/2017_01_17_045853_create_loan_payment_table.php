<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_loan_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('transaction_date');
            $table->integer('transaction_id');
            $table->integer('employee_id');
            $table->integer('loan_id');
            $table->string('outstanding_balance');
            $table->string('amount_to_be_paid');
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
        Schema::dropIfExists('hrm_loan_payment');
    }
}
