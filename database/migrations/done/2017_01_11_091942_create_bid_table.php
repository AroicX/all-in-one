<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_bid', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer("bid_number")->unsigned()->nullable();
            $table->string("bid_opening_date");
            $table->string("bid_opening_time");
            $table->string("name");
            $table->integer("phone")->unsigned();
            $table->string("email")->unique();
            $table->integer("fax");
            $table->string('commodity_desc')->nullable();
            $table->enum("contract_type",['Firm','Term'])->default('Firm');
            $table->string("scope");
            $table->string("bid_items")->nullable();
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
        Schema::dropIfExists('create_bid');
    }
}
