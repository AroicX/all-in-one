<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixedAssetRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_asset_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('account_no');
            $table->integer('asset_sub_account_id'); #table - asset_sub_account
            $table->string('description')->nullable();
            $table->timestamp('date');
            $table->double('amount');
            $table->boolean('disposed')->default(0);
            $table->integer('capital_allowance_completed')->default(0); #table - asset_sub_account
            $table->string('dep_rate')->nullable();
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
        Schema::dropIfExists('fixed_asset_registers');
    }
}
