<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->timestamps();
            $table->string('transaction_date');
            $table->string('effective_date');
            $table->string('old_grade');
            $table->string('new_grade');
            $table->string('old_designation');
            $table->string('new_designation');
            $table->string('old_branch');
            $table->string('new_branch');
            $table->string('old_manager');
            $table->string('new_manager');
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
        Schema::dropIfExists('employee_transfers');
    }
}
