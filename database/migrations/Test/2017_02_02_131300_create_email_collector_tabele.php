<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailCollectorTabele extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corppay_email_collector', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('bid_number');
            $table->string('email',100);
            $table->string('token');
            $table->boolean('sent_email')->nullable();
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
        Schema::dropIfExists('corppay_email_collector');
    }
}
