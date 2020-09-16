<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToShopmove extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('shop_movements', function(Blueprint $table){
            $table->integer('quantity_received');
            $table->string('status')->default('pending');
            $table->date('date_moved');
            $table->date('date_received');
            $table->integer('from');
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
          Schema::table('shop_movements', function(Blueprint $table){
            $table->dropColumn('quantity_received');
            $table->dropColumn('status');
            $table->dropColumn('date_moved');
            $table->dropColumn('date_received');
            $table->dropColumn('from');

        });
    }
}
