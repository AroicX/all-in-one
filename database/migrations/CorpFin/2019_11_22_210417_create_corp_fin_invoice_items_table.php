<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpFinInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corp_fin_invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->nullable();
            $table->string('type');
            $table->integer('item_id')->nullable();
            $table->integer('quantity');
            $table->double('vat');
            $table->double('sub_total');
            $table->double('total');
            $table->double('discount_amount')->default(0);
            $table->double('discount_percent')->default(0);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('corp_fin_invoice_items');
    }
}
