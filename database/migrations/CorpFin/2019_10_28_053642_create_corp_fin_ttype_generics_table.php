<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpFinTtypeGenericsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corp_fin_ttype_generics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_id');
            $table->string('code');
            $table->integer('trans_category_id')->unsigned();
            $table->foreign('trans_category_id')->references('id')->on('trans_categories');
            $table->integer('trans_type_id')->unsigned();
            $table->foreign('trans_type_id')->references('id')->on('trans_types');
            $table->integer('acc_class_id')->unsigned();
            $table->foreign('acc_class_id')->references('id')->on('account_classes');
            $table->integer('acc_sub_class_id')->unsigned();
            $table->foreign('acc_sub_class_id')->references('id')->on('account_sub_classes');
            $table->integer('account_id')->unsigned();
            //$table->foreign('account_id')->references('id')->on('coa');
            $table->integer('dr_cr');
            $table->integer('vat_inc')->default(0);
            $table->integer('vat_exc')->default(0);
            $table->integer('wht')->default(0);
            $table->integer('without_tax')->default(0);
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
        Schema::dropIfExists('corp_fin_ttype_generics');
    }
}
