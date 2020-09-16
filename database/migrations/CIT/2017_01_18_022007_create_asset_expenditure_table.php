<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetExpenditureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corptax_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asset');
            $table->integer('cost');
            $table->integer('initial_allowance_rate');
            $table->integer('annual_allowance_rate');
            $table->integer('investment_allowance_rate')->nullable();
            $table->integer('initial_allowance');
            $table->integer('annual_allowance');
            $table->integer('investment_allowance')->nullable();
            $table->integer('total');
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
        Schema::dropIfExists('corptax_assets');
    }
}
