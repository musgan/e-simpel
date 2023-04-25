<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\UserLevel;
use App\UserLevelGroup;
use App\Secretariat;
use App\IndikatorSector;
use App\Sector;
use DB;

class GenerateIndikatorController extends Controller
{
    //
    public function __construct()
    {

        date_default_timezone_set('Asia/Jakarta');
        $this->sectors = Sector::select('id','nama','alias','category')->orderBy('id','ASC')->get();
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

    public function index(){
    	$indikator_periode = DB::table('secretariats')
    		->select('periode_tahun','periode_bulan',DB::RAW('COUNT(secretariats.id) as total'))
        ->join('sectors','sectors.id','=','sector_id')
    		->groupBy('periode_tahun','periode_bulan')
    		->orderBy('periode_tahun','DESC')
    		->orderBY('periode_bulan','DESC')
    		->paginate(12);
    	$send = [
            'menu' => 'Master',
            'sub_menu' => 'generate_indikator',
            'title'	=> '',
            'indikator_periode'	=> $indikator_periode,
            'menu_sectors'   => $this->sectors,
            'bulan'	=> $this->bulan
        ];
        return view('admin.hawasbid.generate_indikator.index',$send);
    }

    public function store(Request $request){
    	$this->validate($request,[
    		'g_periode_bulan'	=> 'required',
    		'g_periode_tahun'	=> 'required',
    		'periode_bulan'	=> 'required',
    		'periode_tahun'	=> 'required',
    	]);
      // dd(time());

      $default_time = date('Y-m-d H:i:s');


    	$user = Auth::user();
        $id_indikator = "";

        $check_periode = DB::table('secretariats')
        	->where('periode_bulan',$request->periode_bulan)
        	->where('periode_tahun',$request->periode_tahun)
        	->count();
        if($check_periode == 0){
	        $data_generate_sector = DB::table('secretariats')
	        	->join('indikator_sectors','secretariat_id','=','secretariats.id')
            ->join('sectors','sectors.id','=','secretariats.sector_id')
	        	->select('indikator_sectors.sector_id','indikator','user_level_id','secretariat_id','secretariats.sector_id as s_sector_id')
	        	->where('periode_bulan',$request->g_periode_bulan)
	        	->where('periode_tahun',$request->g_periode_tahun)
	        	->orderBy('secretariats.id','ASC')
	        	->orderBy('sector_id','ASC')
	        	->get();

	        // dd($data_generate_sector);
	        $secretariat_id = "";
	        $bath_indikator = array();
	        $bath_indikator_sektor = array();
          $idx = 0;
	        foreach($data_generate_sector as $row){
	        	if($row->secretariat_id != $secretariat_id){
	        		$idx += 1;
              $set_idx = "000";
              
              if($idx < 10)
                $set_idx = "00".$idx;
              else if($idx < 100)
                $set_idx = "0".$idx;
              else $set_idx = $idx;

              // if($secretariat_id != "")
	        		// 	sleep(1);
	        		
	        		$secretariat_id = $row->secretariat_id;
	        		$id_indikator = time().$set_idx.$user->id;
              // dd($id_indikator);

	        		array_push($bath_indikator,array(
	        			'id'	=> $id_indikator,
                'sector_id' => $row->s_sector_id,
	        			'indikator'	=> $row->indikator,
	        			'user_level_id'	=> 10,
	        			'periode_tahun'	=> $request->periode_tahun,
	        			'periode_bulan'	=> $request->periode_bulan,
                'created_at'    => $default_time,
                'updated_at'    => $default_time
	        		));
	        	}

	        	array_push($bath_indikator_sektor, array(
	        		'id'		=> $id_indikator.$row->sector_id,
	        		'sector_id'	=> $row->sector_id,
	        		'secretariat_id'	=> $id_indikator,
              'created_at'    => $default_time,
              'updated_at'    => $default_time
	        	));
	        }

	        Secretariat::insert($bath_indikator);
	        IndikatorSector::insert($bath_indikator_sektor);

	        return redirect(url(session('role').'/generate_indikator'))->with('status',['success','Berhasil Melakukan generate Periode Indikator']);
	    }else{
	    	return redirect(url(session('role').'/generate_indikator'))->with('status',['danger','Indikator untuk periode '.$this->getNameMonth($request->periode_bulan).' '.$request->periode_tahun.' telah tersedia']);
	    }
    }

    public function delete_periode(Request $request){
    	$this->validate($request,[
    		'periode_bulan'	=> 'required',
    		'periode_tahun'	=> 'required',
    	]);
    	DB::table('secretariats')
    		->where('periode_bulan',$request->periode_bulan)
    		->where('periode_tahun',$request->periode_tahun)
    		->delete();

    	return redirect(url(session('role').'/generate_indikator'))->with('status',['success','Berhasil Menghapus Periode Indikator']);
    }

    private function getNameMonth($m){
      $bulan = "";
      switch ($m) {
        case "01":
          $bulan = "Januari";
          # code...
          break;
        case "02":
          $bulan = "Februari";
          # code...
          break;
        case "03":
          $bulan = "Maret";
          # code...
          break;
        case "04":
          $bulan = "April";
          # code...
          break;
        case "05":
          $bulan = "Mei";
          # code...
          break;
        case "06":
          $bulan = "Juni";
          # code...
          break;
        case "07":
          $bulan = "Juli";
          # code...
          break;
        case "08":
          $bulan = "Agustus";
          # code...
          break;
        case "09":
          $bulan = "September";
          # code...
          break;
        case "10":
          $bulan = "Oktober";
          # code...
          break;
        case "11":
          $bulan = "November";
          # code...
          break;
        case "12":
          $bulan = "Desember";
          # code...
          break;
        
        default:
          # code...
          break;
      }

      return $bulan;
    }

}
