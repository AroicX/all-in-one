<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->delete();

        $roles = [

            [
                'id'=>1,
                'name'=>'superadmin',
                'slug' => uniqid(),
                'description'=>'',
                'level' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ];

        DB::table('roles')->insert($roles);
    }
}
