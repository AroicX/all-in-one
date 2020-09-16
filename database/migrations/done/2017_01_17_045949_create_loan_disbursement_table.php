<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanDisbursementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_loan_disbursement', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('transaction_date');
            $table->integer('trasaction_id');
            $table->integer('employee_id');
            $table->integer('loan_id');
            $table->string('disbursed_amount');
            $table->string('mode_of_disbursement');
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
        Schema::dropIfExists('hrm_loan_disbursement');
    }
}
