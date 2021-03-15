<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sector;
class SectorHawasbid extends Controller
{
    
    public function __construct()
    {
        $this->sectors = Sector::select('id','nama','alias','category')->orderBy('id','ASC')->get();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Sector::orderBy('category','ASC')
            ->orderBy('id','ASC')
            ->get();
        $send = [
            'menu' => 'hawasbid',
            'sub_menu'  => 'hawasbid_bidang',
            'title' => '-',
            'send'  => $data,
            'menu_sectors'   => $this->sectors
        ];

        return view('admin.hawasbid.penanggung_jawab.index',$send);
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
        $data = Sector::where('id',$id)->first();

        $send = [
            'menu' => 'hawasbid',
            'sub_menu'  => 'hawasbid_bidang',
            'title' => '-',
            'send'  => $data,
            'menu_sectors'   => $this->sectors
        ];

        return view('admin.hawasbid.penanggung_jawab.edit',$send);
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
            'nip'   => 'required',
            'penanggung_jawab'  => 'required'
        ]);

        $send = Sector::findOrFail($id);
        $send->nip = $request->nip;
        $send->base_color = $request->base_color;
        $send->penanggung_jawab = $request->penanggung_jawab;
        $send->save();

        return redirect(url(session('role').'/sector_hawasbid/'.$id.'/edit'))->with('status','Berhasil memperbaharui Data');
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
