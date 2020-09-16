$<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('client_id');
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('date_sent')->nullable();
            $table->string('status')->default('draft');
            $table->string('payment_method')->nullable();
            $table->float('subtotal')->nullable();
            $table->float('item_tax')->nullable();
            $table->float('invoice_tax')->nullable();
            $table->float('discount_percent')->nullable();
            $table->float('discount_amount')->nullable();
            $table->float('total');
            $table->float('paid');
            $table->float('balance');
            $table->string('password');
            $table->string('invoice_no');
            $table->integer('invoice_group_id');
            $table->string('type')->default('quote');
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
        Schema::dropIfExists('invoices');
    }
}
