<?php

namespace App\Http\Controllers;

use App\Helpers\VariableHelper;
use App\Repositories\LingkupPengawasanBidangRepositories;
use App\Repositories\LingkupPengawasanRepositories;
use App\Repositories\PengawasanRegulerRepositories;
use App\Repositories\SectorRepositories;
use App\Repositories\StatusPengawasanRegularRepositories;
use Illuminate\Http\Request;

class PengawasanRegulerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path_view = "admin.pengawasan-reguler.pengawasan-bidang.";
    private $path_url = "pr/pengawasan-bidang";
    private $path_url_kesesuaian = "pr/kesesuaian";

    private $data = [
        "menu"  => "",
        "sub_menu" => "",
        "path_url"  => "pr/pengawasan-bidang",
        "path_view" => "admin.pengawasan-reguler.pengawasan-bidang.",
        'root_menu' => 'pr_pengawas_bidang',
        'form_detail' => false
    ];

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->data["menu_sectors"] = SectorRepositories::getAllSectors();
        $this->data['dict_periode_of_month'] = VariableHelper::getDictOfMonth();
        $this->data['periode_tahun'] = date('Y');
        $this->data['periode_bulan']    = date('m');
    }

    public function index($sector_category, $sector_alias)
    {
        //
        $sector_selected = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
        $this->data["menu"] = $sector_category;
        $this->data["sub_menu"] = $sector_alias;
        $this->data["path_url"] = $this->getPathUrl($sector_category, $sector_alias);
        $this->data["path_url_kesesuaian"] = $this->getPathUrlKesesuaian($sector_category, $sector_alias);
        $this->data["sector_selected"] = $sector_selected;
        $this->data['status_pengawasan_regular'] = StatusPengawasanRegularRepositories::getAll();
        return view($this->path_view."index", $this->data);
    }

    function getPathUrl($category, $aliasName){
        return $this->path_url."/".$category.'/'.$aliasName;
    }
    function getPathUrlKesesuaian($category, $aliasName){
        return $this->path_url_kesesuaian."/".$category.'/'.$aliasName;
    }

    public function getTable($sector_category, $sector_alias, Request $request){
        $repo = new PengawasanRegulerRepositories($sector_category, $sector_alias);
        $repo->setBaseUrl($this->getPathUrl($sector_category, $sector_alias));
        return $repo->getDataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($sector_category, $sector_alias)
    {
        //
        $repoLingkupPengawasanBidang = new LingkupPengawasanBidangRepositories();
        $sector_selected = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
        if($sector_selected == null)
            return redirect(url("/home"));
        $this->data["menu"] = $sector_category;
        $this->data["sub_menu"] = $sector_alias;
        $this->data["path_url"] = $this->getPathUrl($sector_category, $sector_alias);
        $this->data["path_url_kesesuaian"] = $this->getPathUrlKesesuaian($sector_category, $sector_alias);
        $this->data["sector_selected"] = $sector_selected;
        $this->data['lingkup_pengawasan_bidang']   = $repoLingkupPengawasanBidang->getLingkupPengawasanBidang($sector_selected->id);

        return view($this->path_view."create", $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($sector_category, $sector_alias,Request $request)
    {
        //
        $this->validate($request, [
            'peride_bulan'  => 'required',
            'periode_tahun'  => 'required',
            'item_lingkup_pengawasan_id'  => 'required',
            'temuan'  => 'required',
            'kriteria'  => 'required',
            'sebab'  => 'required',
            'akibat'  => 'required',
            'rekomendasi'  => 'required',
        ], $this->getValidationMessage());

        $repo = new PengawasanRegulerRepositories($sector_category, $sector_alias);
        return $repo->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sector_category, $sector_alias,$id)
    {
        //
        $repo = new PengawasanRegulerRepositories($sector_category, $sector_alias);
        $repoLingkupPengawasanBidang = new LingkupPengawasanBidangRepositories();
        $sector_selected = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
        if($sector_selected == null)
            return redirect(url("/home"));
        $this->data["menu"] = $sector_category;
        $this->data["sub_menu"] = $sector_alias;
        $this->data["path_url"] = $this->getPathUrl($sector_category, $sector_alias);
        $this->data["sector_selected"] = $sector_selected;
        $this->data['lingkup_pengawasan_bidang']   = $repoLingkupPengawasanBidang->getLingkupPengawasanBidang($sector_selected->id);
        $this->data['form'] = $repo->getById($id);
        if($this->data['form'] == null)
            return redirect(url("/home"));
        $this->data['periode_tahun'] = $this->data['form']->periode_tahun;
        $this->data['periode_bulan']    = $this->data['form']->periode_bulan;
        $this->data["form_detail"] = true;

        return view($this->path_view."show", $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($sector_category, $sector_alias,$id)
    {
        //
        $repo = new PengawasanRegulerRepositories($sector_category, $sector_alias);
        $repoLingkupPengawasanBidang = new LingkupPengawasanBidangRepositories();
        $sector_selected = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
        if($sector_selected == null)
            return redirect(url("/home"));
        $this->data["menu"] = $sector_category;
        $this->data["sub_menu"] = $sector_alias;
        $this->data["path_url"] = $this->getPathUrl($sector_category, $sector_alias);
        $this->data["path_url_kesesuaian"] = $this->getPathUrlKesesuaian($sector_category, $sector_alias);
        $this->data["sector_selected"] = $sector_selected;
        $this->data['lingkup_pengawasan_bidang']   = $repoLingkupPengawasanBidang->getLingkupPengawasanBidang($sector_selected->id);
        $this->data['form'] = $repo->getById($id);

        if($this->data['form'] == null)
            return redirect(url("/home"));
        $this->data['periode_tahun'] = $this->data['form']->periode_tahun;
        $this->data['periode_bulan']    = $this->data['form']->periode_bulan;

        return view($this->path_view."edit", $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($sector_category, $sector_alias,Request $request, $id)
    {
        //
        $this->validate($request, [
            'temuan'  => 'required',
            'kriteria'  => 'required',
            'sebab'  => 'required',
            'akibat'  => 'required',
            'rekomendasi'  => 'required',
        ], $this->getValidationMessage());

        $repo = new PengawasanRegulerRepositories($sector_category, $sector_alias);
        return $repo->update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sector_category, $sector_alias,$id)
    {
        //
        $repo = new PengawasanRegulerRepositories($sector_category, $sector_alias);
        return $repo->delete($id);
    }

    function getValidationMessage(){
        return [
            'peride_bulan.required' => 'Periode bulan wajib diisi',
            'periode_tahun.required'    => 'Periode tahun wajib diisi',
            'item_lingkup_pengawasan_id.required'   => 'Lingkup pengawasan wajib diisi',
            'temuan.required'   => 'Temuan wajib diisi',
            'kriteria.required' => 'Kriteria wajib diisi',
            'sebab.required'    => 'Sebab wajib diisi',
            'akibat.required'   => 'Akibat wajib diisi',
            'rekomendasi.required'  => 'Rekomendasi wajib diisi',
        ];
    }
}
