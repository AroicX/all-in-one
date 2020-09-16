<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('bid_number')->unsigned()->index();
            $table->string('company_name');
            $table->string('name');
            $table->string('title');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip')->nullable();
            $table->string('phone');
            $table->string('fax')->nullable;
            $table->string('email');
            $table->string('business_des');
            $table->text('bids_quote');
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
        Schema::dropIfExists('pending_vendors');
    }
}
