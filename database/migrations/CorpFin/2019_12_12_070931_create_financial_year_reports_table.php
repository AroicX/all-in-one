<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialYearReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_year_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->double('gross_profit');
            $table->double('revenue');
            $table->double('direct_cost');
            $table->double('depreciation');
            $table->double('finance_cost');
            $table->double('operating_cost');
            $table->double('profit_before_tax');
            $table->double('accessable_profit');
            $table->double('capital_allowance');
            $table->double('minimum_tax');
            $table->double('taxable_profit');
            $table->double('capital_allowance_bf');
            $table->double('capital_allowance_cf');
            $table->double('capital_allowance_utitlized');
            $table->double('edu_tax');
            $table->text('disallowed_items')->nullable();
            $table->double('disallowed_value')->default(0)->nullable();
            $table->double('coporate_income_tax');
            $table->double('coporate_tax_liability');
            $table->text('meta')->nullable();
            $table->timestamp('from_date');
            $table->timestamp('to_date');
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
        Schema::dropIfExists('financial_year_reports');
    }
}
