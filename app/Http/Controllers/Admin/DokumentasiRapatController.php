<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DokumentasiRapatPengawasanAPMReporitories;
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
        $this->bulan = [
            "01"    => "Januari",
            "02"    => "Februari",
            "03"    => "Maret",
            "04"    => "April",
            "05"    => "Mei",
            "06"    => "Juni",
            "07"    => "Juli",
            "08"    => "Agustus",
            "09"    => "September",
            "10"    => "Oktober",
            "11"    => "November",
            "12"    => "Desember",
        ];

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
