<?php

namespace App\Http\Controllers;

use App\Helpers\VariableHelper;
use App\Repositories\KesesuaianPengawasanRegulerRepositories;
use App\Repositories\SectorRepositories;
use Illuminate\Http\Request;

class KesesuaianPengawasanRegularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path_view = "admin.pengawasan-reguler.kesesuaian-pengawasan-bidang.";
    private $path_url_pengawasan_bidang = "pr/pengawasan-bidang";
    private $path_url = "pr/kesesuaian";

    private $data = [
        "menu"  => "",
        "sub_menu" => "",
        "path_url"  => "",
        "path_view" => "admin.pengawasan-reguler.kesesuaian-pengawasan-bidang.",
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

    public function index()
    {
        //
    }
    function getPathUrl($category, $aliasName){
        return $this->path_url."/".$category.'/'.$aliasName;
    }
    function getPathUrlPengawasanBidang($category, $aliasName){
        return $this->path_url_pengawasan_bidang."/".$category.'/'.$aliasName;
    }

    public function getTable($sector_category, $sector_alias, Request $request){
        $repo = new KesesuaianPengawasanRegulerRepositories($sector_category, $sector_alias);
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
        $sector_selected = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
        $this->data["menu"] = $sector_category;
        $this->data["sub_menu"] = $sector_alias;
        $this->data["path_url"] = $this->getPathUrl($sector_category, $sector_alias);
        $this->data["path_url_pengawasan_bidang"] = $this->getPathUrlPengawasanBidang($sector_category, $sector_alias);
        $this->data["sector_selected"] = $sector_selected;
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
        $this->validate($request, [
            'peride_bulan'  => 'required',
            'periode_tahun' => 'required',
            'uraian_kesesuaian' => 'required'
        ]);
        $repo = new KesesuaianPengawasanRegulerRepositories($sector_category, $sector_alias);
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
        $repo = new KesesuaianPengawasanRegulerRepositories($sector_category, $sector_alias);
        $sector_selected = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
        $this->data["menu"] = $sector_category;
        $this->data["sub_menu"] = $sector_alias;
        $this->data["path_url"] = $this->getPathUrl($sector_category, $sector_alias);
        $this->data["path_url_pengawasan_bidang"] = $this->getPathUrlPengawasanBidang($sector_category, $sector_alias);
        $this->data["sector_selected"] = $sector_selected;
        $this->data["form_detail"] = true;
        $this->data["form"] = $repo->getById($id);
        if($this->data["form"] == null)
            return redirect($this->data["path_url_pengawasan_bidang"]);

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
        $repo = new KesesuaianPengawasanRegulerRepositories($sector_category, $sector_alias);
        $sector_selected = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
        $this->data["menu"] = $sector_category;
        $this->data["sub_menu"] = $sector_alias;
        $this->data["path_url"] = $this->getPathUrl($sector_category, $sector_alias);
        $this->data["path_url_pengawasan_bidang"] = $this->getPathUrlPengawasanBidang($sector_category, $sector_alias);
        $this->data["sector_selected"] = $sector_selected;
        $this->data["form"] = $repo->getById($id);
        if($this->data["form"] == null)
            return redirect($this->data["path_url_pengawasan_bidang"]);

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
            'uraian_kesesuaian' => 'required'
        ]);
        $repo = new KesesuaianPengawasanRegulerRepositories($sector_category, $sector_alias);
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
        $repo = new KesesuaianPengawasanRegulerRepositories($sector_category, $sector_alias);
        return $repo->delete($id);
    }

    public function getMessageValidation(){
        return [
            'peride_bulan.required' => 'Periode bulan wajib diisi',
            'periode_tahun.required'    => 'Periode tahun wajib diisi',
            'uraian_kesesuaian.required'    => 'Uraian wajib diisi'
        ];
    }
}
