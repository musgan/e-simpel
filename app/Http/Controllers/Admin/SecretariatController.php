<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\VariableHelper;
use App\Repositories\IndikatorSectorRepositories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sector;

class SecretariatController extends Controller
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

    public function index($submenu_category, $submenu, Request $request)
    {
        $search = "";
        $periode_bulan = date("m");
        $periode_tahun  = date("Y");
        $evidence = "";

        $full_url = url()->full();
        $request->session()->put('backlink_hawasbid'.$submenu, $full_url);

        $sector = Sector::where('alias',$submenu)->first();

        $send = [
            'menu' => $sector->category,
            'menu_sectors'   => $this->sectors,
            'sub_menu'  => $submenu,
            'root_menu' => 'pengawas_bidang',
            'sector'    => $sector,
            'periode_bulan' => $this->bulan,
            'bulan' => $periode_bulan,
            'tahun' => $periode_tahun,
            'path_url'  => implode("/",['pengawas-bidang',$submenu_category,$submenu]),
            'path_dokumentasi_rapat_url' => implode("/",['pengawas-bidang',$submenu_category,$submenu,"dokumentasi_rapat"])
        ];
        return view('admin.kepaniteraan.index',$send);
    }

    public function getTable($submenu_category, $submenu, Request $request){
        $repo = new IndikatorSectorRepositories($submenu_category, $submenu);
        $repo->setBaseUrl(implode("/",['pengawas-bidang',$submenu_category,$submenu]));
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
        // dd($secretariat);
        
        if($indikator_sector == null)
            return redirect(url('home'));
        $send = [
            'menu' => $sector->category,
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'root_menu' => 'pengawas_bidang',
            'sub_menu'  => $submenu,
            'sector'    => $sector,
            'indikator_sector'  => $indikator_sector,
            'secretariat'   => $indikator_sector->secretariat,
            'dir_evidence'  => implode("/",["public/evidence",$submenu,$indikator_sector->id]),
            'path_url'  => implode("/",['pengawas-bidang',$submenu_category,$submenu])
        ];
        return view('admin.kepaniteraan.show',$send);
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
        $repo = new IndikatorSectorRepositories($submenu_category, $submenu);
        $indikator_sector = $repo->getById($id);
        $sector = $repo->getSector();

        $send = [
            'root_menu' => 'pengawas_bidang',
            'menu' => $sector->category,
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors,
            'sub_menu'  => $submenu,
            'sector'    => $sector,
            'indikator_sector'  => $indikator_sector,
            'secretariat'   => $indikator_sector->secretariat,
            'dir_evidence'  => implode("/",["public/evidence",$submenu,$indikator_sector->id]),
            'path_url'  => implode("/",['pengawas-bidang',$submenu_category,$submenu])
        ];
        return view('admin.kepaniteraan.edit',$send);
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
        $redirect = implode("/",["pengawas-bidang",$submenu_category,$submenu,$id,"edit"]);
        $flash = [
            'status'    => 'success',
            'message'   => 'Update data berhasil'
        ];
        try {
            $repo = new IndikatorSectorRepositories($submenu_category, $submenu);
            $repo->updateUraian($id,$request);
        }catch (\Exception $e){
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
