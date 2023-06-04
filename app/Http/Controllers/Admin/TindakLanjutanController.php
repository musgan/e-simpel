<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\VariableHelper;
use App\Repositories\IndikatorSectorRepositories;
use App\Repositories\SettingPeriodeRepositories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sector;
use Illuminate\Support\Facades\DB;

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
        $this->bulan = VariableHelper::getDictOfMonth();
    }

    public function index($submenu_category,$submenu, Request $request)
    {
        $search = "";
        $periode_bulan = date('m');
        $periode_tahun  = date('Y');
        $evidence = "";

        if(isset($_GET['search']))
            $search = $request->get('search');

        if(isset($_GET['evidence']))
            $evidence = $request->get('evidence');

        if(isset($_GET['periode_bulan']))
            $periode_bulan = $request->get('periode_bulan');
        if(isset($_GET['periode_tahun']))
            $periode_tahun = $request->get('periode_tahun');
        
        $sector = Sector::where('alias',$submenu)->first();



        $send = [
            'menu' => $sector->category,
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'sub_menu'  => $submenu,
            'root_menu' => 'tindak_lanjut',
            'sector'    => $sector,
            'search'      => $search,
            'periode_bulan' => $this->bulan,
            'bulan' => $periode_bulan,
            'tahun' => $periode_tahun,
            'path_url'  => implode("/",["tindak-lanjutan",$submenu_category, $submenu]),
            'path_dokumentasi_rapat_url'    => implode("/",['tindak-lanjutan',$submenu_category,$submenu,"dokumentasi_rapat"])
        ];
        return view('admin.tindak_lanjutan.index',$send);
    }

    public function getTable($submenu_category, $submenu, Request $request){
        $repo = new IndikatorSectorRepositories($submenu_category, $submenu);
        $repo->setKategori("tindak-lanjut");
        $repo->setBaseUrl(implode("/",['tindak-lanjutan',$submenu_category,$submenu]));
        return $repo->getDataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($submenu_category, $submenu)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($submenu_category, $submenu, Request $request)
    {


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
        $repo = new IndikatorSectorRepositories($submenu_category, $submenu);

        $sector = $repo->getSector();
        $indikator_sector = $repo->getById($id);

        if($indikator_sector == null)
            return redirect(url('home'));
        $send = [
            'menu' => $sector->category,
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'root_menu' => 'tindak_lanjut',
            'sub_menu'  => $submenu,
            'sector'    => $sector,
            'indikator_sector'  => $indikator_sector,
            'secretariat'   => $indikator_sector->secretariat,
            'dir_evidence'  => implode("/",["public/evidence",$submenu,$indikator_sector->id]),
            'path_url'  => implode("/",['tindak-lanjutan',$submenu_category,$submenu])
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
        try{
            $repo = new IndikatorSectorRepositories($submenu_category, $submenu);
            $repo->setKategori("tindak-lanjut");
            $indikator_sector = $repo->getById($id);
            if($indikator_sector->secretariat->sector_id !== $repo->getSector()->id)
                throw new \Exception("Tidak bisa melakukan edit data", 400);
            $sector = $repo->getSector();
            $secretariat = $indikator_sector->secretariat;
            SettingPeriodeRepositories::isTindakLanjutAvaibleToupdate($repo->getKategori(),
                $secretariat->periode_tahun,
                $secretariat->periode_bulan);
            $send = [
                'root_menu' => 'tindak_lanjut',
                'menu' => $sector->category,
                'title' => 'Pengguna',
                'menu_sectors'   => $this->sectors,
                'sub_menu'  => $submenu,
                'sector'    => $sector,
                'indikator_sector'  => $indikator_sector,
                'secretariat'   => $secretariat,
                'dir_evidence'  => implode("/",["public/evidence",$submenu,$indikator_sector->id]),
                'path_url'  => implode("/",['tindak-lanjutan',$submenu_category,$submenu])
            ];
            return view('admin.tindak_lanjutan.edit',$send);
        }catch (\Exception $e){
            $redirect = implode("/",["tindak-lanjutan",$submenu_category,$submenu]);
            $message = [
                'status'    => 'error',
                'message'   => $e->getMessage()
            ];
            return redirect(url($redirect))->with($message);
        }
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
        $redirect = implode("/",["tindak-lanjutan",$submenu_category,$submenu,$id,"edit"]);
        $flash = [
            'status'    => 'success',
            'message'   => 'Update data berhasil'
        ];
        DB::beginTransaction();
        try {
            $repo = new IndikatorSectorRepositories($submenu_category, $submenu);
            $repo->setKategori("tindak-lanjut");
            $repo->updateUraian($id,$request);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            $flash['status']    = "error";
            $flash['message']   = "Update data gagal ".$e->getMessage();
            if ($e->getCode() == 400){
                $flash['message']   = $e->getMessage();
            }
        }
        return redirect(url($redirect))->with($flash);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($submenu_category, $submenu, $id)
    {

    }
}
