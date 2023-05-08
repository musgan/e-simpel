<?php

namespace App\Http\Controllers;

use App\Repositories\DokumentasiRapatPengawasanRegulerRepositories;
use Illuminate\Http\Request;

class DokumentasiRapatPengawasanRegularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path_url = "pr/dokumentasi-rapat";
    public function index()
    {
        //
    }

    function getPathUrl($category, $aliasName){
        return $this->path_url."/".$category.'/'.$aliasName;
    }

//    return array and no data table format
    public function getTable($sector_category, $sector_alias, Request $request){
        $repo = new DokumentasiRapatPengawasanRegulerRepositories($sector_category, $sector_alias);
        if($request->kategori_dokumentasi)
            $repo->setKategori($request->kategori_dokumentasi);
        $repo->setBaseUrl($this->getPathUrl($sector_category, $sector_alias));
        return $repo->getDataTableArray($request);
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
    public function store($sector_category, $sector_alias, Request $request)
    {
        $this->validate($request, [
            'kategori_dokumentasi'  => 'required',
            'periode_bulan' => 'required',
            'periode_tahun' => 'required'
        ]);
        $repo = new DokumentasiRapatPengawasanRegulerRepositories($sector_category, $sector_alias);
        $repo->setKategori($request->kategori_dokumentasi);
        $repo->setBaseUrl($this->getPathUrl($sector_category, $sector_alias));
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
    public function destroy($sector_category, $sector_alias, Request $request)
    {
        $this->validate($request, [
            'periode'   => 'required',
            'time' => 'required',
            'kategori' => 'required',
            'filename' => 'required',
            'category' => 'required',
        ]);
        $repo = new DokumentasiRapatPengawasanRegulerRepositories($sector_category, $sector_alias);
        $repo->setKategori($request->kategori);
        return $repo->delete($request);
    }
}
