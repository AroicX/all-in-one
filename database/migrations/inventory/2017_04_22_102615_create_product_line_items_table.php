<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_line_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('product_line_id');
            $table->integer('quantity');
            $table->integer('reorder_level');
            $table->integer('reorder_quantity');
            $table->float('overhead_allocation');
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
        Schema::dropIfExists('product_line_items');
    }
}
