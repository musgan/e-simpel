<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Sector;
use App\UserLevel;
use App\UserLevelGroup;
use App\Secretariat;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\indikatorSector;
use DB;

class TindakLanjutanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function index($submenu_category,$submenu, Request $request)
    {
        $search = "";
        $periode_bulan = "";
        $periode_tahun  = "";
        $evidence = "";

        $full_url = url()->full();
        $request->session()->put('backlink_tl'.$submenu, $full_url);
        
        if(isset($_GET['search']))
            $search = $request->get('search');

        if(isset($_GET['evidence']))
            $evidence = $request->get('evidence');

        if(isset($_GET['periode_bulan']))
            $periode_bulan = $request->get('periode_bulan');
        if(isset($_GET['periode_tahun']))
            $periode_tahun = $request->get('periode_tahun');
        
        $sector = Sector::where('alias',$submenu)->first();


        $secretariats = DB::table('indikator_sectors')
                ->join('secretariats','secretariats.id','=','secretariat_id')
                ->join('sectors','sectors.id','indikator_sectors.sector_id')
                ->where('secretariats.sector_id',$sector->id)
                ->select('indikator_sectors.id','indikator','periode_tahun','periode_bulan','evidence','secretariats.created_at','sectors.nama', 'indikator_sectors.uraian');

        $secretariats = $secretariats->where(function($q){
            $q->where('status_tindakan',1)
                ->orWhere('evidence',0);

            // if(date('d') < 16 && date('d') > 4){
            //     $m = date('m');
            //     $y = date('Y');
            //     $treshold_date = $y."-".$m."-05";
            //     $treshold_d =  strtotime($treshold_date." -1 month");

                
            //     $q->orWhere(function($qq) use($treshold_d){

            //         $qq->where('periode_tahun',date('Y',$treshold_d))
            //         ->where('periode_bulan',date('m', $treshold_d))
            //         ->Where('evidence',0);
            //     });
            // }
            
        });
        $treshold_time = strtotime('-2 month');
        if(date('d') > 4){
            $treshold_time = strtotime('-1 month');
        }

        $secretariats->whereDate(DB::raw('CONCAT(periode_tahun,"-",periode_bulan,"-01")'),"<=",date('Y-m-01',$treshold_time));
        

        if($search != ""){
            $secretariats = $secretariats->where('indikator','like','%'.$search.'%');
        }

        
        $secretariats = $secretariats->orderBy('secretariats.updated_at','DESC');
        if($periode_bulan != "")
            $secretariats = $secretariats->where('periode_bulan',$periode_bulan);
        if($periode_tahun != "")
            $secretariats = $secretariats->where('periode_tahun',$periode_tahun);

        $secretariats = $secretariats->orderBy('periode_tahun','DESC')
            ->orderBy('periode_bulan','DESC');

        $secretariats = $secretariats->paginate(15);
        $secretariats->withPath('?search='.$search.'&periode_bulan='.$periode_bulan.'&periode_tahun='.$periode_tahun);


        $send = [
            'menu' => $sector->category,
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'sub_menu'  => $submenu,
            'root_menu' => 'tindak_lanjut',
            'sector'    => $sector,
            'secretariats'  => $secretariats,
            'search'      => $search,
            'periode_bulan' => $this->bulan
        ];
        return view('admin.tindak_lanjutan.index',$send);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($submenu_category, $submenu)
    {
        //
        $user = Auth::user();
        $sector = Sector::where('alias',$submenu)->first();
        $send = [
            'menu' => $sector->category,
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'sub_menu'  => $submenu,
            'root_menu' => 'tindak_lanjut',
            'sector'    => $sector
        ];
        return view('admin.tindak_lanjutan.create',$send);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($submenu_category, $submenu, Request $request)
    {

        //
        // $this->validate($request,[
        //     'indikator' => 'required'
        // ]);
        // $evidence = 0;
        // if($request->file('evidence')){
        //     $evidence = 1;
        // }

        // $user = Auth::user();
        
        // $sector = Sector::where('alias',$submenu)->first();
        // $id = date('YmdHis').rand(1111,9999);
        // $send = new Secretariat;
        // $send->id = $id;
        // $send->user_level_id = $this->user_levels;
        // $send->sector_id = $sector->id;
        // $send->evidence = $evidence;
        // $send->indikator = $request->indikator;

        // if($request->uraian){
        //     $send->uraian = $request->uraian;
        // }

        // $send->save();

        // if($evidence == 1){
            
        //     $tot_file  = 0;
        //     foreach($request->evidence as $file){

        //         $fname = $file->getClientOriginalName();
        //         $pth ="public/evidence/".$submenu."/".$id."/";
        //         $fname = $this->checkfileName($fname, $pth);

        //         $file->storeAs($pth, $fname);
        //         $tot_file += 1;
        //     }
        // }

        // return redirect(url(session('role').'/kepaniteraan/'.$submenu.'/'.$id))->with('status','Berhasil Menambah Data');
    }

    private function validateAction($indikator_sector_id){
        $user = Auth::user();
        $action = 0;

        $secretariat = DB::table('indikator_sectors')
            ->join('secretariats','secretariats.id','=','secretariat_id')
            ->where('indikator_sectors.id',$indikator_sector_id)
            ->select('periode_bulan','periode_tahun')->first();

        if($secretariat)
            $action = \CostumHelper::checkActionTindakLanjut($user->user_level_id, $secretariat->periode_bulan, $secretariat->periode_tahun);

        return $action;
    }

    public function upload_evidence($submenu_category, $submenu, $id, Request $request)
    {
        //

        if($this->validateAction($id) == 0){
            return redirect(session('role').'/home');
        }


        if($request->file('evidence')){
            $directory = "public/evidence/".$submenu."/".$id;
            foreach($request->evidence as $file){
                $fname = $file->getClientOriginalName();
                $pth =   $directory."/";
                $fname = $this->checkfileName($fname, $pth);
                
                $file->storeAs($pth,$fname);
            }
            $files = Storage::allFiles($directory);

            if(count($files) > 0){
                DB::table('indikator_sectors')
                    ->where('id',$id)
                    ->update([
                        'evidence'  => 1
                    ]);
            }

        }
        return redirect(url(session('role').'/tindak-lanjutan/kepaniteraan/'.$submenu.'/'.$id));
    }

    public function checkfileName($file_name, $pth){
        if(Storage::exists($pth.$file_name)) {
            $path_parts = pathinfo($pth.$file_name);

            $file_name = $this->checkfileName($path_parts['filename']."_copy.".$path_parts['extension'], $pth);
        }
        return $file_name;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($submenu_category, $submenu,$id)
    {
        //
        $sector = Sector::where('alias',$submenu)->first();
        $secretariat = DB::table('indikator_sectors')->where('indikator_sectors.id',$id)
            ->join('secretariats','secretariats.id','=','secretariat_id')
            ->join('sectors','sectors.id','=','indikator_sectors.sector_id')
            ->where('secretariats.sector_id',$sector->id)
            ->select('indikator_sectors.id','indikator','uraian','evidence','nama','periode_bulan','periode_tahun')
            ->first();
        // dd($secretariat);
        
        if($secretariat == null)
            return redirect(url(session('role').'/home'));
        $send = [
            'menu' => $sector->category,
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'root_menu' => 'tindak_lanjut',
            'sub_menu'  => $submenu,
            'sector'    => $sector,
            'secretariat'   => $secretariat
        ];
        return view('admin.tindak_lanjutan.show',$send);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($submenu_category, $submenu,$id)
    {
        //
        if($this->validateAction($id) == 0){
            return redirect(session('role').'/home');
        }
        
        $user = Auth::user();
        $sector = Sector::where('alias',$submenu)->first();
        $secretariat = DB::table('indikator_sectors')->where('indikator_sectors.id',$id)
            ->join('secretariats','secretariats.id','secretariat_id')
            ->join('sectors','sectors.id','indikator_sectors.sector_id')
            ->select('indikator_sectors.id','uraian','periode_tahun','periode_bulan','indikator','nama as bidang')
            ->first();

        $send = [
            'root_menu' => 'tindak_lanjut',
            'menu' => $sector->category,
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'sub_menu'  => $submenu,
            'sector'    => $sector,
            'send'   => $secretariat
        ];
        return view('admin.tindak_lanjutan.edit',$send);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($submenu_category, $submenu,Request $request, $id)
    {
        //
        $this->validate($request,[
            'uraian'    => 'required'
        ]);

        if($this->validateAction($id) == 0){
            return redirect(session('role').'/home');
        }
        

        $send = indikatorSector::where('id',$id)->first();
        $send->uraian = $request->uraian;
        $send->status_tindakan = 1;
        
        $send->save();

        return redirect(url(session('role').'/tindak-lanjutan/kepaniteraan/'.$submenu.'/'.$id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($submenu_category, $submenu, $id)
    {
        //

        // $directory = "public/evidence/".$submenu."/".$id;
        // Storage::deleteDirectory($directory);

        // $sector = Sector::where('alias',$submenu)->first();

        // Secretariat::where('id',$id)
        //     ->where('sector_id',$sector->id)
        //     ->delete();

        // return redirect(url(session('role').'/kepaniteraan/'.$submenu));
    }

    

    public function destroy_file($submenu_category, $submenu, $id, Request $request)
    {
        //
        if($this->validateAction($id) == 0){
            return redirect(session('role').'/home');
        }

        $file = $request->get('file');
        Storage::delete($file);

        $directory = "public/evidence/".$submenu."/".$id;
        $files = Storage::allFiles($directory);

        if(count($files) == 0){
            DB::table('indikator_sectors')
                ->where('id',$id)
                ->update([
                    'evidence'  => 0
                ]);
        }

        return redirect(url(session('role').'/tindak-lanjutan/kepaniteraan/'.$submenu.'/'.$id));
    }
}
