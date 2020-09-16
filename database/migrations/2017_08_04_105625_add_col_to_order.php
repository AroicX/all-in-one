<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('orders' , function(Blueprint $table){
            $table->integer('company_id');
            $table->date('payment_date')->nullable();
            $table->string('supplier_name')->nullable();
            $table->float('amount_paid')->nullable();
            $table->date('date_received')->nullable();
            $table->string('status')->default('In Transit');
            $table->string('payment_status')->default('Not yet paid');
            $table->float('balance')->nullable();
            $table->float('total')->nullable();
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
          Schema::table('orders' , function(Blueprint $table){
            $table->dropColumn('company_id');
            $table->dropColumn('payment_date')->nullable();
            $table->dropColumn('supplier_name')->nullable();
            $table->dropColumn('amount_paid')->nullable();
            $table->dropColumn('date_received')->nullable();
            $table->dropColumn('status')->default('In Transit');
            $table->dropColumn('payment_status')->default('Not yet paid');
            $table->dropColumn('balance');
            $table->dropColumn('total');
            $table->dropColumn('description');
        });
    }
}
