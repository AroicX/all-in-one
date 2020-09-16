<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQouteReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qoute_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref');
            $table->integer('invoice_id');
            $table->string('subject')->nullable();
            $table->text('review');
            $table->string('user');
            $table->timestamps();
            // $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qoute_reviews');
    }
}
