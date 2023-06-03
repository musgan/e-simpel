<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\VariableHelper;
use App\Repositories\DokumentasiRapatPengawasanAPMReporitories;
use App\Repositories\IndikatorSectorRepositories;
use App\Repositories\SettingPeriodeRepositories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Sector;
use DB;

class DokumentasiRapatController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->sectors = Sector::select('id','nama','alias','category')
            ->orderBy('category','ASC')
            ->orderBy('id','ASC')->get();
        $this->user_levels = 10;
        $this->bulan = VariableHelper::getDictOfMonth();
    }

    public function getTable($submenu_category, $submenu, Request $request){
        $repo = new DokumentasiRapatPengawasanAPMReporitories($submenu_category, $submenu);
        if($request->kategori_dokumentasi)
            $repo->setKategori($request->kategori_dokumentasi);
        $pth = "";
        if($repo->getKategori() == "hawasbid")
            $pth = "pengawas-bidang";
        else
            $pth = "tindak-lanjutan";
        $repo->setBaseUrl(implode("/",[$pth,$submenu_category, $submenu,"dokumentasi_rapat"]));

        return $repo->getDataTableArray($request);
    }

    public function store($submenu_category, $submenu, Request $request){
    	$this->validate($request,[
    		'periode_bulan'	=> 'required',
    		'periode_tahun'	=> 'required',
    	]);
        $message = [
            'status'    => 'success',
            'message'   => 'Berhasil Menambah dokumentasi'
        ];
        $bulan = $request->periode_bulan;
        $tahun = $request->periode_tahun;
        $kategori_redirect = "pengawas-bidang";
        if($request->kategori_dokumentasi == "tindak-lanjut")
            $kategori_redirect = "tindak-lanjutan";

        $redirect = url(implode("/",[$kategori_redirect,$submenu_category, $submenu]));
        try {
            SettingPeriodeRepositories::isTindakLanjutAvaibleToupdate($request->kategori_dokumentasi,
                $request->periode_tahun,
                $request->periode_bulan);
            SettingPeriodeRepositories::isHawasbidAvaibleToupdate($request->kategori_dokumentasi,
                $request->periode_tahun,
                $request->periode_bulan);

            $repo  = new DokumentasiRapatPengawasanAPMReporitories($submenu_category, $submenu);
            $repo->setKategori($request->kategori_dokumentasi);

            $repo->store($request);
        }catch (\Exception $e){
            $message = [
                'status'    => 'error',
                'message'   => $e->getMessage()
            ];
        }
        return redirect($redirect.'?periode_bulan='.$bulan.'&periode_tahun='.$tahun)->with($message);
    }

    public function destroy($submenu_category, $submenu, Request $request){

    	$this->validate($request,[
    		'bulan'	=> 'required',
    		'tahun'	=> 'required',
    		'path'	=> 'required'
    	]);
        $message  = [
            'status'    => "success",
            'message'  => 'Berhasil menghapus data dokumentasi rapat'
        ];
        $kategori_url = "pengawas-bidang";
        if($request->kategori == "tindak-lanjut")
            $kategori_url = "tindak-lanjutan";

        try{

            $repo = new DokumentasiRapatPengawasanAPMReporitories($submenu_category, $submenu);
            SettingPeriodeRepositories::isTindakLanjutAvaibleToupdate($request->kategori,
                $request->periode_tahun,
                $request->periode_bulan);
            SettingPeriodeRepositories::isHawasbidAvaibleToupdate($request->kategori,
                $request->periode_tahun,
                $request->periode_bulan);

            $repo->delete($request);
        }catch (\Exception $e){
            $message  = [
                'status'    => "error",
                'message'  => $e->getMessage()
            ];
        }
        $redirect = url(implode("/",[$kategori_url,$submenu_category, $submenu]));
    	return redirect($redirect.'?periode_bulan='.$request->bulan.'&periode_tahun='.$request->tahun)->with($message);
    }
}
