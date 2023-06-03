<?php

namespace App\Repositories;

use App\SettingPeriodHawasbid;

class SettingPeriodeRepositories
{
    public static function isTindakLanjutAvaibleToupdate($kategori, $periode_tahun, $periode_bulan){
        if($kategori != "tindak-lanjut")
            return;
        $currentDate = date("Y-m-d");
        $model = SettingPeriodHawasbid::where('periode_bulan',$periode_bulan)
            ->where('periode_tahun', $periode_tahun)
            ->whereRaw('? BETWEEN start_periode_tindak_lanjut and stop_periode_tindak_lanjut',[$currentDate])
            ->first();
        if($model == null)
            throw new \Exception("Proses data gagal karena tidak dalam batas waktu yang ditentukan",400);
    }
    public static function isHawasbidAvaibleToupdate($kategori, $periode_tahun, $periode_bulan){
        if($kategori != "hawasbid")
            return;
        $currentDate = date("Y-m-d");
        $model = SettingPeriodHawasbid::where('periode_bulan',$periode_bulan)
            ->where('periode_tahun', $periode_tahun)
            ->whereRaw('? BETWEEN start_input_session and stop_input_session',[$currentDate])
            ->first();
        if($model == null)
            throw new \Exception("Proses data gagal karena tidak dalam batas waktu yang ditentukan",400);
    }
}