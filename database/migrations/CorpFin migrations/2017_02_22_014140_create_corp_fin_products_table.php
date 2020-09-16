<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpFinProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corp_fin_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('name');
            $table->string('category');
            $table->string('measure');
            $table->string('taxes');
            $table->string('rp')->nullable();
            $table->string('taxes_description')->nullable();

            $table->decimal('price', 9, 2);
            $table->softDeletes();

            $table->integer('vat_id')->nullable()->unsigned();
            $table->integer('wht_id')->nullable()->unsigned();


            $table->foreign('company_id')
                ->references('id')->on('company')->onDelete('cascade');

            $table->foreign('vat_id')
                ->references('id')->on('vats')->onDelete('SET NULL');

            $table->foreign('wht_id')
                ->references('id')->on('whts')->onDelete('SET NULL');


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
        Schema::dropIfExists('corp_fin_products');
    }
}
