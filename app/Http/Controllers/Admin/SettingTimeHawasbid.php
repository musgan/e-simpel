<?php

namespace App\Http\Controllers\admin;

use App\Helpers\VariableHelper;
use App\Repositories\SettingPeriodeHawasbidRepositories;
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
        $repo = new SettingPeriodeHawasbidRepositories();
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
            'stop_periode_tindak_lanjut' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $repo = new SettingPeriodeHawasbidRepositories();
            $repo->save($request);
            DB::commit();
            return redirect(url('/setting_time_hawasbid'))->with([
                'status'    => 'success',
                'message'   => 'Berhasil menambah data'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return redirect(url('/setting_time_hawasbid'))->with([
                'status'    => 'error',
                'message'   => ($e->getCode() == 400)?$e->getMessage():'Gagal memperbaharui data'
            ]);
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
            return redirect(url('/setting_time_hawasbid'));
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
            'stop_periode_tindak_lanjut' => 'required',
            'status_periode'            => 'required'
        ]);
        DB::beginTransaction();
        try {
            $repo = new SettingPeriodeHawasbidRepositories();
            $repo->update($id, $request);
            DB::commit();
            return redirect(url('/setting_time_hawasbid'))->with([
                'status'    => 'success',
                'message'   => 'Berhasil Memperbaharui Data'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return redirect(url('/setting_time_hawasbid'))->with([
                'status'    => 'success',
                'message'   => ($e->getCode() == 400)?$e->getMessage():'Gagal memperbaharui data'
            ]);
        }
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
