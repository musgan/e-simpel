<?php

namespace App\Repositories;

use App\SettingPeriodHawasbid;
use Illuminate\Http\Request;

class SettingPeriodeHawasbidRepositories
{
    function isPeriodeHasAvaible($periode_bulan, $periode_tahun){
        $model =  SettingPeriodHawasbid::where('periode_tahun', $periode_tahun)
            ->where('periode_bulan', $periode_bulan)
            ->first();
        if($model){
            throw new \Exception("Periode telah ada. Silahkan edit data tersebut", 400);
        }
    }
    public static function getPeriodeActive(){
        return SettingPeriodHawasbid::where('status_periode','A')->get();

    }
    public function save(Request $request){

        $this->isPeriodeHasAvaible($request->periode_bulan, $request->periode_tahun);

        $model = new SettingPeriodHawasbid;
        $model->periode_bulan = $request->periode_bulan;
        $model->periode_tahun = $request->periode_tahun;
        $model->start_input_session = $request->start_input_session;
        $model->stop_input_session = $request->stop_input_session;
        $model->start_periode_tindak_lanjut = $request->start_periode_tindak_lanjut;
        $model->stop_periode_tindak_lanjut = $request->stop_periode_tindak_lanjut;
        $model->status_periode = "A";
        $model->save();

    }

    public function update($id,Request $request){

        $model = SettingPeriodHawasbid::findOrFail($id);
        if($request->status_periode == "NA" & $model->status_periode == "A")
            PengawasanRegulerRepositories::updateStatusBelumDiselesaikanPengawasanRegular($model->periode_bulan, $model->periode_tahun);

        $model->start_input_session = $request->start_input_session;
        $model->stop_input_session = $request->stop_input_session;
        $model->start_periode_tindak_lanjut = $request->start_periode_tindak_lanjut;
        $model->stop_periode_tindak_lanjut = $request->stop_periode_tindak_lanjut;
        $model->status_periode = $request->status_periode;

        $model->save();
    }
}