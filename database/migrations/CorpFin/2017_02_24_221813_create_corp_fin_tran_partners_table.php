<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpFinTranPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('corp_fin_tran_partners'))
        {
            Schema::create('corp_fin_tran_partners', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('tel')->nullable();
                $table->string('comp_numb')->nullable();
                $table->string('tin')->nullable();
                $table->text('address')->nullable();
                $table->integer('country_id')->unsigned();
                $table->foreign('country_id')->references('id')->on('countries');
                $table->integer('state_id')->unsigned();
                $table->foreign('state_id')->references('id')->on('states');
                $table->string('document')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corp_fin_tran_partners');
    }
}
