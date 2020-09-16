<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_movements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch_id');
            $table->integer('shop_id');
            $table->integer('quantity_moved');
            $table->float('shipping');
            $table->float('damages');
            $table->float('handling');
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
        Schema::dropIfExists('shop_movements');
    }
}
