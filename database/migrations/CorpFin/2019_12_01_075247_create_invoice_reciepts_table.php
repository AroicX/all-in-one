<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceRecieptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_reciepts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->double('amount');
            $table->string('channel'); #bank draft, bank payment, bank transfer, online
            $table->string('refrence_no');
            $table->string('status');
            // $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
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
        Schema::dropIfExists('invoice_reciepts');
    }
}
