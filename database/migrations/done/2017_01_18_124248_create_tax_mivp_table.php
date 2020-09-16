<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxMivpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_mivp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->double('balance',15,5);
            $table->double('vat_output',15,5);
            $table->double('vat_input',15,5);
            $table->double('vat_lessPayment',15,5);
            $table->double('closing_balance',15,5);
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
        Schema::dropIfExists('tax_mivp');
    }
}
