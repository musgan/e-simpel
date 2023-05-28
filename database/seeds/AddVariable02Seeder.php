<?php

use Illuminate\Database\Seeder;

class AddVariable02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('variables')
            ->insert([
                [
                    'key'           => 'KEPANITERAANPOSITIONNAME',
                    'value'         => '',
                    'keterangan'    => 'Nama jabatan oleh kepaniteraan'
                ],
                [
                    'key'           => 'KESEKTARIATANPOSITIONNAME',
                    'value'         => '',
                    'keterangan'    => 'Nama jabatan oleh kesektariatan'
                ]
            ]);
    }
}
