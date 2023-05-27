<?php

use Illuminate\Database\Seeder;

class AddVariableSeeder extends Seeder
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
                    'key'           => 'EMPLOYEEKEPANITERAANNAME',
                    'value'         => '',
                    'keterangan'    => 'Nama pegawai yang bertanggung jawab pada kepaniteraan'
                ],
                [
                    'key'           => 'EMPLOYEEKEPANITERAANNIP',
                    'value'         => '',
                    'keterangan'    => 'NIP pegawai yang bertanggung jawab pada kepaniteraan'
                ],
                [
                    'key'           => 'EMPLOYEEKESEKTARIATANNAME',
                    'value'         => '',
                    'keterangan'    => 'Nama pegawai yang bertanggung jawab pada kesektariatan'
                ],
                [
                    'key'           => 'EMPLOYEEKESEKTARIATANNIP',
                    'value'         => '',
                    'keterangan'    => 'NIP pegawai yang bertanggung jawab pada kesektariatan'
                ],
            ]);
    }
}
