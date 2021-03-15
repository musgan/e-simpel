<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\UserLevel;
use App\UserLevelGroup;
use App\Sector;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        date_default_timezone_set('Asia/Jakarta');
        $this->sectors = Sector::select('id','nama','alias','category')->orderBy('id','ASC')->get();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_level = UserLevel::where('id',$user->user_level_id)->first();
        // echo $user->id;
        $sector = UserLevelGroup::where('user_id',$user->id)
            ->join('sectors','sector_id','=','sectors.id')
            ->select('nama')
            ->get();
        $domain_sector = [];
        foreach ($sector as $key => $value) {
            # code...
            array_push($domain_sector, $value->nama);
        }

        $date_start30 = date('Y-m-d', strtotime('-30 days'));
        $date_end30 = date('Y-m-d');
        
        $date_start7 = date('Y-m-d', strtotime('-7 days'));
        $date_end7 = date('Y-m-d');
        
        $year = date('Y');
        

        $check_evidence = DB::table('indikator_sectors')
            ->join('secretariats','secretariats.id','=','secretariat_id')
            ->join('sectors','sectors.id','=','secretariats.sector_id')
            ->select(DB::raw('count(secretariats.id) as total'),'sectors.nama as nama','alias','sectors.id')
            ->groupBy('sectors.id','sectors.nama','alias')
            ->where('evidence',0)
            ->orderBy('sectors.category','ASC')
            ->orderBy('sectors.id','ASC');

        

        $tindak_lanjut_evidence = [];
        $m = date('m');
        $y = date('Y');
        $treshold_d = null;
        $periode_tindak_lanjut = "";

        $treshold_temuan  = null;
        $treshold_date = $y."-".$m."-03";

        if(date('d') < 16){
            $treshold_d =  strtotime($treshold_date." -1 month");
            $tindak_lanjut_evidence = clone $check_evidence;
            $tindak_lanjut_evidence = $tindak_lanjut_evidence
                ->where('periode_tahun',date('Y',$treshold_d))
                ->where('periode_bulan',date('m', $treshold_d))
                ->get();
            
            $periode_tindak_lanjut = \CostumHelper::getNameMonth(date('m', $treshold_d)).' '.date('Y',$treshold_d);

            $treshold_temuan = strtotime($treshold_date." -2 month");
            
        }else{
            $treshold_temuan = strtotime($treshold_date." -1 month");
        }

        $time_temuan = $treshold_temuan;
        $treshold_temuan = date('Y-m',$treshold_temuan)."-01";

        // $current_periode_evidence = clone $check_evidence;
        // $current_periode_evidence = $current_periode_evidence->where('periode_bulan',date('m'))
        //                                 ->where('periode_tahun',date('Y'))
        //                                 ->get();

        $hasil_temuan_evidence = clone $check_evidence;
        $hasil_temuan_evidence = $hasil_temuan_evidence->whereDate(DB::raw('CONCAT(periode_tahun,"-",periode_bulan,"-01")'),"<=",$treshold_temuan)->get();

        // dd($hasil_temuan_evidence);
        $all_sector = DB::table('sectors')->orderBy('category','ASC')
          ->orderBy('nama','ASC')
          ->pluck('nama','id');
        
        $labels = array();
        $idx_label = [];
        $idx = 0;
        foreach ($all_sector as $key => $val) {
          # code...
          array_push($labels, $val);
          $idx_label[$key] = $idx;

          $idx++;
        }

        $init_data_tl = array_fill(0, count($labels), 0);
        $init_data_temuan = array_fill(0, count($labels), 0);

        foreach ($tindak_lanjut_evidence as $row) {
          # code...
          $init_data_tl[$idx_label[$row->id]] = $row->total;
        }

        foreach ($hasil_temuan_evidence as $row) {
          # code...
          $init_data_temuan[$idx_label[$row->id]] = $row->total;
        }

        $data_chart = array();
        $data_chart['labels'] = $labels;
        $data_chart['datasets'] = array(
          array(
            "label"           => "Tindak Lanjut Periode ".$periode_tindak_lanjut,
            "backgroundColor" => "#7868e6",//"rgb(255, 99, 132)",
            "borderColor"     => "#7868e6",
            "data"            => $init_data_tl
          ),
          array(
            "label"           => "Hasil Temuan Hingga ".\CostumHelper::getNameMonth(date('m',$time_temuan))." ".date('Y',$time_temuan),
            "backgroundColor" => "#ec4646",
            "borderColor"     => "#ec4646",
            "data"            => $init_data_temuan
          ),
        );

        // chart performa tindak lanjut

        

        $send = [
            'menu' => 'dashboard',
            'title' => 'Dashboard',
            'user'  => $user,
            'user_level'    => $user_level,
            'domain_sector' => $domain_sector,
            'menu_sectors'   => $this->sectors,
            'data_chart'  => json_encode($data_chart)
        ];
        return view('admin.dashboard',$send);
    }


    
}
