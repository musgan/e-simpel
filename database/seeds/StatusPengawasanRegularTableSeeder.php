<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class StatusPengawasanRegularTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('status_pengawasan_regular')->insert([
            [
                'id' => 'SUBMITEDBYHAWASBID',
                'nama' => 'Dibuat oleh hawasbid',
                'text_color' => 'white',
                'background_color' => '#36b9cc', #text-info
                'icon' => '<i class="fa fa-file-o" aria-hidden="true"></i>',
                'urutan'    => 1
            ],
            [
                'id' => 'WAITINGAPPROVALFROMADMIN',
                'nama' => 'Menunggu persetujuan dari admin',
                'text_color' => 'white',
                'background_color' => '#f6c23e', #text-warning
                'icon' => '<i class="fa fa-clock-o" aria-hidden="true"></i>',
                'urutan'    => 2
            ],
            [
                'id' => 'APPROVED',
                'nama' => 'Telah disetujui oleh admin',
                'text_color' => 'white',
                'background_color' => '#1cc88a', #text-success
                'icon' => '<i class="fa fa-check-circle" aria-hidden="true"></i>',
                'urutan'    => 3
            ],
            [
                'id' => 'NOTRESOLVED',
                'nama' => 'Belum diselesaikan',
                'text_color' => 'white',
                'background_color' => '#e74a3b', #text-warning
                'icon' => '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>',
                'urutan'    => 4
            ]
            ]);
    }
}
