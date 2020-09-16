<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToProductlines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('product_lines', function($table){
            $table->integer('user_id');
            $table->string('name');
            $table->string('additional_info');
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
        Schema::table('product_lines', function($table){
            $table->dropColumn('user_id');
            $table->dropColumn('name');
            $table->dropColumn('additional_info');
        });
    }
}
