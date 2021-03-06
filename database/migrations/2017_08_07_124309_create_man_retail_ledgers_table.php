<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManRetailLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('man_retail_ledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('account_id');
            $table->string('acc_name');
            $table->string('description');
            $table->date('date');
            $table->integer('class_id');
            $table->float('Dr')->nullable();
            $table->float('Cr')->nullable();
            $table->string('account_no');
            $table->integer('subclass_id');
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
        Schema::dropIfExists('man_retail_ledgers');
    }
}
