<?php

namespace App\Http\Controllers;

use App\Repositories\SectorRepositories;
use App\Repositories\VariableRepositories;
use Illuminate\Http\Request;

class VariableController extends Controller
{
    private $path_view = "admin.variable.";
    private $path_url = "variables";

    private $data = [
        "menu"  => "Master",
        "sub_menu" => "variables",
        "path_url"  => "variables",
        "path_view" => "admin.variable."
    ];
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->data["menu_sectors"] = SectorRepositories::getAllSectors();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view($this->path_view."index", $this->data);
    }

    public function getTable(Request $request){
        $repo = new VariableRepositories();
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
    public function edit($key)
    {
        $this->data['form'] = VariableRepositories::getByKey($key);
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
            'value' => 'required',
            'keterangan'    => 'required'
        ], $this->getValidationMessage());
        $repo = new VariableRepositories();
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
    }

    private function getValidationMessage(){
        return [
            'value.required'    => 'Field nilai wajib ada',
            'keterangan.required'    => 'Field keterangan wajib ada',
        ];
    }
}
