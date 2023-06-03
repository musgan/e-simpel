<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\HawasbidIndikatorRepositories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Illuminate\Support\Facades\Auth;
use App\Sector;
use App\UserLevel;
use App\UserLevelGroup;
use App\Secretariat;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\IndikatorSector;


class HawasbidIndikatorController extends Controller
{
   
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $full_url = url()->full();
        $request->session()->put('backlink_indikator_hawasbid', $full_url);

        $search = "";
        $periode_tahun = date('Y');
        $periode_bulan = date('m');
        $evidence = "";
        
        if(isset($_GET['search']))
            $search = $request->get('search');
        
        if(isset($_GET['evidence']))
            $evidence = $request->get('evidence');


        if(isset($_GET['periode_tahun']))
            $periode_tahun = $request->get('periode_tahun');
        if(isset($_GET['periode_bulan']))
            $periode_bulan = $request->get('periode_bulan');

        $summary =  DB::table('secretariats')
            ->select('sectors.id',"sectors.nama",DB::raw("COUNT(sectors.id) as total_indikator"))
            ->leftJoin('sectors','sector_id','=','sectors.id')
            ->where('periode_bulan',$periode_bulan)
            ->where('periode_tahun',$periode_tahun)
            ->groupBy('sectors.id','sectors.nama')
            ->orderBy('periode_tahun','DESC')
            ->orderBy('periode_bulan','DESC')
            ->orderBy('sectors.nama','ASC')
            ->orderBy('secretariats.indikator','ASC')
            ->get();

        $send = [
            'menu'              => 'Master',
            'title'             => 'hawasbid',
            'menu_sectors'      => $this->sectors,
            'sub_menu'          => "hawasbid_indikator",
            'periode_bulan'     => $this->bulan,
            'evidence'          => $evidence,
            'bulan'             => $periode_bulan,
            'tahun'             => $periode_tahun,
            'summary'           => $summary
        ];
        return view('admin.hawasbid.indikator.index',$send);
    }

    public function getTable(Request  $request){
        $repo = new HawasbidIndikatorRepositories();
        $repo->setBaseUrl("hawasbid_indikator");
        return $repo->getDataTable($request);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();
        $sectors = Sector::orderBy('sectors.category','ASC')
                ->orderBy("sectors.id","ASC")
                ->select(DB::RAW('CONCAT(category," - ",nama) as nama'),"sectors.id as id")
                ->pluck('nama','id');

        $sectors_select = [];
        $periode_bulan_select = date('m');
        $periode_tahun_select = date('Y');

        $send = [
            'menu' => "Master",
            'sub_menu'  => "hawasbid_indikator",
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'sectors'    => $sectors,
            'periode_bulan' => $this->bulan,
            'sectors_select'    => $sectors_select,
            'periode_bulan_select'    => $periode_bulan_select,
            'periode_tahun_select'    => $periode_tahun_select
        ];
        return view('admin.hawasbid.indikator.create',$send);
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
            'indikator' => 'required',
            'sector_id' => 'required',
            'tahun' => 'required',
            'bulan' => 'required',
            'pj_sector_id'  => 'required'
        ]);
        $user = Auth::user();
        $id_indikator = time().$user->id;
        

        $send = new Secretariat;
        $send->id = $id_indikator;
        $send->user_level_id = 10;
        $send->sector_id = $request->pj_sector_id;
        $send->indikator = rtrim(ltrim($request->indikator));
        $send->periode_tahun = $request->tahun;
        $send->periode_bulan = $request->bulan;
        $send->save();

        if($send){
            for ($i=0; $i < count($request->sector_id) ; $i++) { 
                # code...
                $id_s = $id_indikator.$request->sector_id[$i];
                $send_sec = new IndikatorSector;
                $send_sec->id = $id_s;
                $send_sec->secretariat_id = $id_indikator;
                $send_sec->sector_id = $request->sector_id[$i];
                $send_sec->save();
            }
        }

        return redirect(url('/hawasbid_indikator/create'))->with('status','Berhasil Menambah Data');
        // }
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
        // $sector = Sector::where('alias',$submenu)->first();
        $secretariat = DB::table('secretariats')->where('secretariats.id',$id)
            ->leftJoin('sectors','sector_id','=','sectors.id')->first();

        
        $ev_sector = DB::table('indikator_sectors')->where('secretariat_id',$id)
            ->join('sectors','sectors.id','=','sector_id')
            ->select('sectors.nama','indikator_sectors.id','evidence','uraian','category','alias')
            ->get();

        if($secretariat == null)
            return redirect(url('/home'));
        $send = [
            'title' => '-',
            'menu_sectors'   => $this->sectors,
            'menu' => "hawasbid",
            'sub_menu'  => "hawasbid_indikator",
            'ev_sector'    => $ev_sector,
            'secretariat'   => $secretariat
        ];
        return view('admin.hawasbid.indikator.show',$send);
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
        $user = Auth::user();
        $sectors = Sector::orderBy('sectors.category','ASC')
                ->orderBy("sectors.id","ASC")
                ->select(DB::RAW('CONCAT(category," - ",nama) as nama'),"sectors.id as id")
                ->pluck('nama','id');

        $sectors_select = IndikatorSector::where('secretariat_id',$id)->pluck('sector_id');
        $send_edit = DB::table('secretariats')
            ->where('id',$id)
            ->select('id','indikator','user_level_id','created_at','periode_tahun','periode_bulan','sector_id as pj_sector_id')
            ->first();

        $periode_bulan_select = $send_edit->periode_bulan;
        $periode_tahun_select = $send_edit->periode_tahun;

        $send = [
            'menu' => "Master",
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'sub_menu'  => "hawasbid_indikator",
            'sectors'    => $sectors,
            'periode_bulan' => $this->bulan,
            'sectors_select'    => $sectors_select,
            'periode_bulan_select'    => $periode_bulan_select,
            'periode_tahun_select'    => $periode_tahun_select,
            'send'  => $send_edit
        ];
        return view('admin.hawasbid.indikator.edit',$send);
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
            'indikator' => 'required',
            'sector_id' => 'required',
            'tahun' => 'required',
            'bulan' => 'required',
            'pj_sector_id'  => 'required'
        ]);

        $send = Secretariat::where('id',$id)->first();
       
        $send->indikator = $request->indikator;
        $send->periode_tahun = $request->tahun;
        $send->periode_bulan = $request->bulan;
        $send->sector_id = $request->pj_sector_id;
        $send->save();
        if($send){
            // echo "update berhasil";
            $ck_array = array();
            $db_sektor = DB::table('indikator_sectors')->where('secretariat_id',$id)->select('sector_id','id')->get();
            $sector_id = $request->sector_id;

            foreach ($db_sektor as $vsektor) {
                # code...
                if(in_array($vsektor->sector_id, $sector_id)){
                    $idx = array_search($vsektor->sector_id, $sector_id);
                    unset($sector_id[$idx]);
                }else{
                    IndikatorSector::where('id',$vsektor->id)->delete();
                }
            }
            // dd($sector_id);
            foreach($sector_id as $vnsec) { 
                # code...
                $id_s = $id.$vnsec;
                $send_sec = new IndikatorSector;
                $send_sec->id = $id_s;
                $send_sec->secretariat_id = $id;
                $send_sec->sector_id = $vnsec;
                $send_sec->save();
            }

        }
        return redirect(url('/hawasbid_indikator/'.$id.'/edit'))->with('status','Berhasil Memperbaharui Data');
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
        Secretariat::where('id',$id)
            ->delete();

        return redirect(

            (session('backlink_indikator_hawasbid'))? session('backlink_indikator_hawasbid'): 
            url('/hawasbid_indikator')
            
        )->with('status','Berhasil Menghapus Data');
    }
}
