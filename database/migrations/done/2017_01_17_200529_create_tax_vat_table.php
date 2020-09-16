<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxVatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_vat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('tax_period');
            $table->string('start_of_month');
            $table->string('end_of_month');
            $table->double('sales_income',15,3);
            $table->double('exempted_supplies',15,3);
            $table->double('total_subject_to_vat',15,3);
            $table->double('vat_charged_by_you',15,3);
            $table->double('add_adjustments',15,3);
            $table->double('total_output_vat',15,3);
            $table->double('vat_on_domestic_supplies',15,3);
            $table->double('add_adjustments_2',15,3);
            $table->double('vat_on_import',15,3);
            $table->double('vat_payable_by_you');
            $table->double('not_vatable_supplies_vat',15,3);
            $table->double('vat_taken_at_source',15,3);
            $table->double('total_input_vat',15,3);
            $table->double('amount_refundable',15,3);
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
        Schema::dropIfExists('tax_vat');
    }
}
