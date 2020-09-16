<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->timestamps();
            $table->string('name');
            $table->string('type');
            $table->tinyInteger('is_taxable')->default(0);
            $table->string('frequency');
            $table->string('mode');
            $table->string('value');
            $table->string('effective_month');
            $table->string('calculate');
            $table->string('assign_to_grade');
            $table->string('nature');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allowances');
    }
}
