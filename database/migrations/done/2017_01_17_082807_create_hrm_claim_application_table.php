<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrmClaimApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_claim_application', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('transaction_date');
            $table->integer('transaction_id');
            $table->string('employee');
            $table->string('claims_date');
            $table->string('expense_type');
            $table->integer('amount');
            $table->text('purpose');
            $table->enum('status', ['accepted','rejected'])->nullable();
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
        Schema::dropIfExists('hrm_claim_application');
    }
}
