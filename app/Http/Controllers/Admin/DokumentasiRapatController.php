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

    public function index($submenu_category, $submenu, Request $request){
    	$tahun = "";
    	$bulan = "";

    	$user = \Auth::user();
        
        $user_levels = DB::table('user_levels')->where('id',$user->user_level_id)->first();
    	if(isset($_GET['periode_bulan']))
    		$bulan = $request->get('periode_bulan');

    	if(isset($_GET['periode_tahun']))
    		$tahun = $request->get('periode_tahun');
    	

    	$sector = Sector::where('alias',$submenu)->first();
    	$total_indikator = DB::table('secretariats')
    		->where('periode_bulan',$bulan)
    		->where('periode_tahun',$tahun)
    		->count();

    	$send = [
            'menu' => $sector->category,
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'sub_menu'  => $submenu,
            'root_menu' => 'pengawas_bidang',
            'sector'    => $sector,
            'periode_bulan' => $this->bulan,
            'bulan'	=> $bulan,
            'tahun'	=> $tahun,
            'total_indikator'	=> $total_indikator,
            'user_levels'	=> $user_levels
        ];
        return view('admin.kepaniteraan.dokumentasi_rapat.index',$send);
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
    	$bulan = $request->periode_bulan;
    	$tahun = $request->periode_tahun;
        $user = \Auth::user();

        $action = \CostumHelper::checkActionHawasbid($user->user_level_id, $bulan, $tahun);

        if($action == 0){
            return redirect(url(session('role').'/home'));
        }

    	$pth = "public/evidence/".$submenu."/dokumentasi_rapat/".$tahun.'-'.$bulan.'/hawasbid/';
    	$root_fname = date('Ymd');
    	if($request->notulensi){

    		$pth_notulen = $root_fname.'_notulen_';
    		foreach ($request->notulensi as $file) {
    			# code...
    			$fname = $pth_notulen.$file->getClientOriginalName();
    			$fname = $this->checkfileName($fname, $pth);

    			$file->storeAs($pth,$fname);
    		}
    	}

    	if($request->absensi){

    		$pth_absensi = $root_fname.'_absensi_';
    		foreach ($request->absensi as $file) {
    			# code...
    			$fname = $pth_absensi.$file->getClientOriginalName();
    			$fname = $this->checkfileName($fname, $pth);

    			$file->storeAs($pth,$fname);
    		}
    	}


    	if($request->foto){

    		$pth_foto = $root_fname.'_foto_';
    		foreach ($request->foto as $file) {
    			# code...
    			$fname = $pth_foto.$file->getClientOriginalName();
    			$fname = $this->checkfileName($fname, $pth);

    			$file->storeAs($pth,$fname);
    		}
    	}
        $redirect = url(implode("/",["pengawas-bidang",$submenu_category, $submenu]));
    	return redirect($redirect.'?periode_bulan='.$bulan.'&periode_tahun='.$tahun)->with('status','Berhasil Menambah dokumentasi');
    }

    public function checkfileName($file_name, $pth){
        if(Storage::exists($pth.$file_name)) {
            $path_parts = pathinfo($pth.$file_name);

            $file_name = $this->checkfileName($path_parts['filename']."_copy.".$path_parts['extension'], $pth);
            // dd("ada");
        }else{

        	// dd("tidak ada ".$pth.$file_name);
        }
        // dd("tidak ada ".$pth.$file_name);
        return $file_name;
    }

    public function destroy($submenu_category, $submenu, Request $request){

    	$this->validate($request,[
    		'bulan'	=> 'required',
    		'tahun'	=> 'required',
    		'path'	=> 'required'
    	]);

    	$bulan = $request->bulan;
    	$tahun = $request->tahun;

        $user = \Auth::user();

        $action = \CostumHelper::checkActionHawasbid($user->user_level_id, $bulan, $tahun);

        if($action == 0){
            return redirect(url(session('role').'/home'));
        }

    	$pth = str_replace("storage/", "public/", $request->path);

    	$explode_pth = explode("/",$pth);


    	$user = \Auth::user();
    	$user_levels = DB::table('user_levels')->where('id',$user->user_level_id)->first();
    	if($user_levels->alias == $explode_pth[5] || $user_levels->id == 1){
    		Storage::delete($pth);
    	}
        $redirect = url(implode("/",["pengawas-bidang",$submenu_category, $submenu]));

    	return redirect($redirect.'?periode_bulan='.$request->bulan.'&periode_tahun='.$tahun)->with('status','Berhasil menghapus data dokumentasi rapat');
    }
}
