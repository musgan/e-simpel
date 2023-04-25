<?php

namespace App\Http\Controllers;

use App\Repositories\LingkupPengawasanBidangRepositories;
use App\Repositories\LingkupPengawasanRepositories;
use App\Repositories\SectorRepositories;
use Illuminate\Http\Request;

class LingkupPengawasanBidangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path_view = "admin.pengawasan-reguler.lingkup-pengawasan-bidang.";
    private $path_url = "pr/lingkup-pengawasan-bidang";
    private $data = [
        "menu"  => "Master",
        "sub_menu" => "lingkup-pengawasan-bidang",
        "path_url"  => "pr/lingkup-pengawasan-bidang",
        "path_view" => "admin.pengawasan-reguler.lingkup-pengawasan-bidang."
    ];
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->data["menu_sectors"] = SectorRepositories::getAllSectors();
    }
    public function index()
    {
        //

        return view($this->path_view."index", $this->data);
    }
    public function getTable(Request $request){
        $repo = new LingkupPengawasanBidangRepositories();
        $repo->setBaseUrl($this->path_url);
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
        $repoLP = new LingkupPengawasanRepositories("");
        $this->data["lingkup_pengawasan"] = $repoLP->getAll();
        return view($this->path_view."create", $this->data);
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
        $this->validate($request, [
            'sector_id' => 'required',
            'lingkup_pengawasan_id' => 'required'
        ], $this->getMessage());
        return LingkupPengawasanBidangRepositories::store($request);
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
    public function edit($sector_id)
    {
        //
        $repoLP = new LingkupPengawasanRepositories("");
        $repo = new LingkupPengawasanBidangRepositories();
        $this->data["lingkup_pengawasan"] = $repoLP->getAll();
        $this->data["lingkup_pengawasan_bidang"] = $repo->getLingkupPengawasanBidang($sector_id);
        $this->data['sector_id'] = $sector_id;
        return view($this->path_view."edit", $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($sector_id, Request $request)
    {
        //
        $this->validate($request, [
//            'sector_id' => 'required',
            'lingkup_pengawasan_id' => 'required'
        ], $this->getMessage());

        $repo = new LingkupPengawasanBidangRepositories();
        return $repo->update($sector_id,$request);
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

    private function getMessage(){
        return [
            'sector_id.required' => 'Bidang wajib dipilih',
            'lingkup_pengawasan_id.required' => 'Lingkup pengawasan wajib dipilih'
        ];
    }
}
