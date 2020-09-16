<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('products', function(Blueprint $table){
            $table->integer('quantity_ordered')->nullable();
            $table->integer('quantiy_sold')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('unit_cost')->nullable();

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
        Schema::table('products', function(Blueprint $table){
            $table->dropColumn('quantity_ordered');
            $table->dropColumn('quantiy_sold');
            $table->dropColumn('quantity');
            $table->dropColumn('unit_cost');
            
        });
    }
}
