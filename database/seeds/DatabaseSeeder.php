<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//      Schema::create('users', function(Blueprint $table)
//      {
//          $table->increments('id');
//          $table->string('name', 50);
//          $table->string('username', 50);
//          $table->string('email', 320);
//          $table->string('password', 200);
//
//                      // required for Laravel 4.1.26
//                      $table->string('remember_token', 100)->nullable();
//          $table->timestamps();
//      });


        //calls seeder files to seed the database with initial data

        Model::unguard();

        $this->call(RolesTableSeeder::class);

        Model::reguard();

    }
}
