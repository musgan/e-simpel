<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->update([
            'password' => bcrypt('12345')
        ]);
    }
}
