<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();

        $users = [

            [
                'role_id' => 1,
                'name'=>'Superior Administrator',
                'email'=>'emmabidem@gmail.com',
                'password'=>bcrypt('EMMAbidem@fruitiza.2017'),
                'is_active' => 1,
                'slug' => uniqid(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]

        ];

        DB::table('users')->insert($users);
    }
}
