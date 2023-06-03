<?php

namespace App\Http\Controllers\admin;

use App\Helpers\VariableHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sector;
use DB;
use App\SettingPeriodHawasbid;

class SettingTimeHawasbid extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->sectors = Sector::select('id','nama','alias','category')->orderBy('id','ASC')->get();
        $this->bulan = VariableHelper::getDictOfMonth();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = SettingPeriodHawasbid::orderBy('periode_tahun','DESC')
            ->orderBy('periode_bulan','DESC')
            ->get();

        $send = [
            'menu'              => 'Master',
            'title'             => 'SETTING PERIODE HAWASBID',
            'menu_sectors'      => $this->sectors,
            'sub_menu'          => "setting_time_hawasbid",
            'periode_bulan'     => $this->bulan,
            'data'              => $data
        ];
        return view('admin.hawasbid.setting_time.index', $send);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $send = [
            'menu'              => 'Master',
            'title'             => 'SETTING PERIODE HAWASBID',
            'sub_menu'          => "setting_time_hawasbid",
            'periode_bulan'     => $this->bulan,
            'menu_sectors'      => $this->sectors,
        ];
        return view('admin.hawasbid.setting_time.create', $send);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'periode_tahun' => 'required',
            'periode_bulan' => 'required',
            'start_input_session' => 'required',
            'stop_input_session' => 'required',
            'start_periode_tindak_lanjut' => 'required',
            'stop_periode_tindak_lanjut' => 'required'
        ]);
        // melakukan check apakah periode telah ada ataw belum
        $checkData =  SettingPeriodHawasbid::where('periode_tahun', $request->periode_tahun)
            ->where('periode_bulan', $request->periode_bulan)
            ->first();

        if ($checkData !== null) {
            return redirect(url('/setting_time_hawasbid'))->with('failed','Gagal memasukan data. Periode telah ada. Silahkan anda mengubah atau menghapus periode yang telah ada');
        }else{

            $send = new SettingPeriodHawasbid;
            $send->periode_bulan = $request->periode_bulan;
            $send->periode_tahun = $request->periode_tahun;
            $send->start_input_session = $request->start_input_session;
            $send->stop_input_session = $request->stop_input_session;
            $send->start_periode_tindak_lanjut = $request->start_periode_tindak_lanjut;
            $send->stop_periode_tindak_lanjut = $request->stop_periode_tindak_lanjut;

            $send->save();

            return redirect(url('/setting_time_hawasbid'))->with('status','Berhasil Menambah Data');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = SettingPeriodHawasbid::where('id',$id)->first();
        if($data !== null){
            $send = [
                'menu'              => 'Master',
                'title'             => 'SETTING PERIODE HAWASBID',
                'menu_sectors'      => $this->sectors,
                'sub_menu'          => "setting_time_hawasbid",
                'periode_bulan'     => $this->bulan,
                'data'              => $data
            ];
            return view('admin.hawasbid.setting_time.edit', $send);
        }else{
            return redirect(url('/setting_time_hawasbid'))
            ->with('failed','Hei, anda kemungkinan salah link');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'periode_tahun' => 'required',
            'periode_bulan' => 'required',
            'start_input_session' => 'required',
            'stop_input_session' => 'required',
            'start_periode_tindak_lanjut' => 'required',
            'stop_periode_tindak_lanjut' => 'required'
        ]);

        $send = SettingPeriodHawasbid::findOrFail($id);
        $send->start_input_session = $request->start_input_session;
        $send->stop_input_session = $request->stop_input_session;
        $send->start_periode_tindak_lanjut = $request->start_periode_tindak_lanjut;
        $send->stop_periode_tindak_lanjut = $request->stop_periode_tindak_lanjut;

        $send->save();

        return redirect(url('/setting_time_hawasbid'))->with('status','Berhasil Memperbaharui Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        SettingPeriodHawasbid::findOrFail($id)->delete();
        return redirect(url('/setting_time_hawasbid'))->with('status','Berhasil Menghapus Periode');
    }
}
