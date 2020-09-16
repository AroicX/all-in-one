<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('employees')) {
            Schema::create('employees', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('company_id');
                $table->timestamps();
                /*Personal Information */
                $table->string('sbirs');
                $table->string('residential_address');
                $table->string('permanent_address');
                $table->string('religion');
                $table->string('telephone_no');
                $table->string('mobile_no');
                $table->string('personal_email_address');
                $table->string('official_email_address');
                $table->string('national_id_no');
                $table->string('driver_license_no');
                $table->string('state_of_origin');
                $table->string('local_govt_area');
                $table->string('blood_group');
                $table->string('genotype');
                $table->string('hmo');
                $table->string('postal_address');
                $table->string('pension_fund_administrator');
                $table->string('pension_pin_no');
                $table->string('no_of_children');
                $table->string('name_of_spouse');
                $table->string('gender');
                $table->string('date_of_birth');
                $table->string('phone_no_spouse');
                $table->string('marital_status');
                $table->string('nationality');
                $table->string('city');
                $table->string('country_address');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
