<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_purchase', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('name_of_product');
            $table->integer('vatable');
            $table->double('price',15,5);
            $table->double('gross_amount',15,5)->nullable();
            $table->double('net_amount',15,5)->nullable();
            $table->double('vat_amount',15,5)->nullable();
            $table->date('date');
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
        Schema::dropIfExists('tax_purchase');
    }
}
