<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeExitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_exits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->timestamps();
            $table->string('branch');
            $table->string('resignation_date');
            $table->integer('employee_id');
            $table->text('reason');
            $table->string('last_working_date');
            $table->text('manager_comments');
            $table->string('responsiblities_over_to');
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
        Schema::dropIfExists('employee_exits');
    }
}
