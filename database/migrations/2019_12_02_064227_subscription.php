<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Subscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('package');
            $table->integer('company_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('product');
            $table->unsignedInteger('featured_id')->nullable();
            $table->date('date');
            $table->time('time');
            $table->integer('duration');
            $table->string('refx_code');
            $table->boolean('status')->default(1);
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
        //
    }
}
