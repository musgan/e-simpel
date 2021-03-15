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
		DB::table('users')->insert([
            'name' => "musgan",
            'email' => 'musgan@gmail.com',
            'level_id' => 1,
            'password' => bcrypt('akusayangkamu'),
        ]);
    }
}
