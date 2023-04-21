<?php

namespace App\Http\Controllers;

use App\Repositories\LingkupPengawasanRepositories;
use App\Repositories\SectorRepositories;
use Illuminate\Http\Request;

class LingkupPengawasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path_view = "admin.pengawasan-reguler.lingkup-pengawasan.";
    private $path_url = "pr/lingkup-pengawasan";

    private $data = [
        "menu"  => "PR-HAWASBID",
        "sub_menu" => "lingkup-pengawasan",
        "path_url"  => "pr/lingkup-pengawasan",
        "path_view" => "admin.pengawasan-reguler.lingkup-pengawasan."
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

    public function getTable(Request $request)
    {
        $repo = new LingkupPengawasanRepositories($this->path_url);
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
            'id_items'  => 'required',
            'name'  => 'required'
        ], $this->getMessage());

        $repo = new LingkupPengawasanRepositories($this->path_url);
        return $repo->store($request);
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
        $repo = new LingkupPengawasanRepositories($this->path_url);
        $this->data["form"] = $repo->getById($id);
        return view($this->path_view."show", $this->data);
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
        $repo = new LingkupPengawasanRepositories($this->path_url);
        $this->data["form"] = $repo->getById($id);
        return view($this->path_view."edit", $this->data);
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
        $this->validate($request, [
            'id_items'  => 'required',
            'name'  => 'required'
        ], $this->getMessage());

        $repo = new LingkupPengawasanRepositories($this->path_url);
        return $repo->update($id, $request);
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
        $repo = new LingkupPengawasanRepositories($this->path_url);
        return $repo->delete($id);
    }

    private function getMessage(){
        return [
            'id_items.required' => 'Item lingkup pengawasan tidak ada',
            'name.required' => 'Nama lingkup pengawasan wajib diisi'
        ];
    }
}
