<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRateOfCapitalAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_capital_allowances_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rates_name');
            $table->integer('initial_allowance');
            $table->integer('annual_allowance');
            $table->integer('investment_allowance')->nullable();
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
        Schema::dropIfExists('tax_capital_allowances_rates');
    }
}
