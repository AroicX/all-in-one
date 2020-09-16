<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToBatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::table('batches', function($table) {
            $table->integer('quantity');
            $table->integer('quantity_sold');
            $table->float('ROI');
            $table->float('batch_turnover');
            $table->float('price');
            $table->float('batch_profitability');
            $table->integer('warehouse_id');
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
         Schema::table('batches', function($table) {
         $table->dropColumn('quantity');
         $table->dropColumn('quantity_sold');
         $table->dropColumn('ROI');
         $table->dropColumn('batch_turnover');
         $table->dropColumn('price');
         $table->dropColumn('batch_profitability');
         $table->dropColumn('warehouse_id');
    });
    }
}
