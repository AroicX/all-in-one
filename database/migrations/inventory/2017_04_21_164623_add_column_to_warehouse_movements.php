<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToWarehouseMovements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('warehouse_movements', function($table) {
            $table->integer('batch_id');
            $table->integer('from');
            $table->integer('to');
            $table->integer('quantity_moved');
            $table->float('shipping');
            $table->float('damages');
            $table->float('handling');
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
         Schema::table('warehouse_movements', function($table) {
             $table->dropColumn('batch_id');
            $table->dropColumn('from');
            $table->dropColumn('to');
            $table->dropColumn('quantity_moved');
            $table->dropColumn('shipping');
            $table->dropColumn('damages');
            $table->dropColumn('handling');
    });
    }
}
