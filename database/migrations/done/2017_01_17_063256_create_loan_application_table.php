<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_loan_application', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('application_ref');
            $table->string('application_date');
            $table->integer('employee_id');
            $table->string('contact_no');
            $table->integer('loan_id')->nullable();
            $table->string('loan_max_limit');
            $table->string('loan_amount');
            $table->string('no_of_installments');
            $table->string('installment_amount');
            $table->string('remarks');
            $table->string('loan_doc_name');
            $table->string('loan_doc_file')->nullable();
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
        Schema::dropIfExists('hrm_loan_application');
    }
}
