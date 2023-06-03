<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\VariableHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Sector;
use DB;

use App\PerformaSector;
use App\SettingPeriodHawasbid;

class PerformaHawasbidController extends Controller
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
    public function index(Request $request)
    {
        $indikator_periode = "";
        $periode_tahun = null;
        $periode_bulan = null;
        if(isset($_GET['periode_tahun']) && isset($_GET['periode_bulan'])){
            $periode_bulan = $request->get('periode_bulan');
            $periode_tahun = $request->get('periode_tahun');

            $indikator_periode = \CostumHelper::getNameMonth($periode_bulan).' '.$periode_tahun;

        }
        //
        $send = [
            'menu' => 'Master',
            'sub_menu' => 'performa_hawasbid',
            'title' => '-',
            'indikator_periode' => $indikator_periode,
            'menu_sectors'   => $this->sectors,
            'bulan' => $this->bulan,
            'data'  => DB::table('performa_sectors')
                ->where('periode_tahun',$periode_tahun)
                ->where('periode_bulan',$periode_bulan)
                ->join('sectors','sectors.id','=','sector_id')
                ->orderBy('sectors.category','ASC')
                ->orderBy('sectors.nama','ASC')
                ->get()
        ];
        return view('admin.hawasbid.performa.index',$send);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        ]);

        $periode_tahun = $request->periode_tahun;
        $periode_bulan = $request->periode_bulan;

        // check indikator tersedia atau tidak
        $base_query = DB::table('secretariats')
            ->join('indikator_sectors','secretariats.id','=','secretariat_id')
            ->where('periode_tahun',$periode_tahun)
            ->where('periode_bulan',$periode_bulan)
            ->whereNotNull('secretariats.sector_id');

        $check_sektor = clone $base_query;
        if($check_sektor->count() > 0){
            PerformaSector::where('periode_bulan',$periode_bulan)
                ->where('periode_tahun',$periode_tahun)
                ->delete();

            $this->calculate_performa($base_query, $periode_bulan, $periode_tahun);
        }

        return redirect(url('/performa-hawasbid?periode_tahun='.$periode_tahun.'&periode_bulan='.$periode_bulan));
    }

    private function calculate_performa($base_query, $periode_bulan, $periode_tahun){
        // get treshold each periode
        $periode = SettingPeriodHawasbid::where('periode_bulan', $periode_bulan)
            ->where('periode_tahun', $periode_tahun)
            ->first();
        if ($periode) {
            // getting total evidence each sectors
            $total_evicence = clone $base_query;
            $total_evicence = $total_evicence
                ->groupBy('secretariats.sector_id')
                ->select('secretariats.sector_id',DB::raw('COUNT(secretariats.sector_id) as total'))->get();

            // mengambil informasi sektor
            $sectors = DB::table('sectors')->select('id')->get();

            // init_val
            $init_val = [];
            foreach ($sectors as $val) {
                 # code...
                $init_val[$val->id]['total_bidang_success'] = 0;
                $init_val[$val->id]['total_bidang_success'] = 0;
                $init_val[$val->id]['total_tindak_lanjut'] = 0;
                $init_val[$val->id]['total_tindak_lanjut_success'] = 0;
            }

            foreach ($total_evicence as $val) {
                # code...
                $init_val[$val->sector_id]['total_bidang'] = $val->total;
            }

            // mengambil total evidence yang diselesaikan
            $total_evidence_selesai = clone $base_query;
            $total_evidence_selesai = $total_evidence_selesai
                ->where('evidence',1)
                ->whereBetween(DB::raw('DATE(indikator_sectors.updated_at)'),[$periode->start_input_session, $periode->stop_input_session])
                
                ->groupBy('secretariats.sector_id')
                ->select('secretariats.sector_id',DB::raw('COUNT(secretariats.sector_id) as total'))->get();

            foreach ($total_evidence_selesai as $val) {
                # code...
                $init_val[$val->sector_id]['total_bidang_success'] = $val->total;
                $init_val[$val->sector_id]['total_tindak_lanjut'] = $init_val[$val->sector_id]['total_bidang'] - $val->total;
            }

            $total_evidence_tindak_lanjut = clone $base_query;
            $total_evidence_tindak_lanjut = $total_evidence_tindak_lanjut
                ->where('evidence',1)
                
                ->whereBetween(DB::raw('DATE(indikator_sectors.updated_at)'),[$periode->start_periode_tindak_lanjut, $periode->stop_periode_tindak_lanjut])

                ->groupBy('secretariats.sector_id')
                ->select('secretariats.sector_id',DB::raw('COUNT(secretariats.sector_id) as total'))->get();


            foreach($total_evidence_tindak_lanjut as $val){
                $init_val[$val->sector_id]['total_tindak_lanjut_success'] = $val->total;
            }

            $batch = array();
            foreach ($init_val as $key => $value) {
                # code...
                array_push($batch, array(
                    'periode_bulan' => $periode_bulan,
                    'periode_tahun' => $periode_tahun,
                    'sector_id' => $key,
                    'total_bidang' => $value['total_bidang'],
                    'total_bidang_success' => $value['total_bidang_success'],
                    'total_tindak_lanjut' => $value['total_tindak_lanjut'],
                    'total_tindak_lanjut_success' => $value['total_tindak_lanjut_success'])
                );
            }

            PerformaSector::insert($batch);
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
    }
}
