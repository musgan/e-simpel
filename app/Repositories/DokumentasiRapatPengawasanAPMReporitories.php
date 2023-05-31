<?php

namespace App\Repositories;

use App\Helpers\DataTableHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumentasiRapatPengawasanAPMReporitories
{
    private $base_url = "";
    private $kategori = "hawasbid";

    private $sector_category = "";
    private $sector_alias = "";

    public function __construct($sector_category, $sector_alias)
    {
        $this->sector_category = $sector_category;
        $this->sector_alias = $sector_alias;
        $this->sector = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
    }

    public function setBaseUrl($base_url){
        $this->base_url = $base_url;
    }
    public function setKategori($kategori){
        $this->kategori = $kategori;
    }
    public function getKategori(){
        return $this->kategori;
    }

    public function getDataTableArray(Request  $request){
        $dtbHelper = new DataTableHelper($request);
        try {
            if($request->periode_bulan == null || $request->periode_tahun == null)
                throw new \Exception("Anda harus memilih periode",400);
            $datatable = array();

            $periode = $request->periode_tahun."-".$request->periode_bulan;
            $perent_dir = "public/evidence/" . $this->sector_alias . "/dokumentasi_rapat/".$periode."/".$this->kategori;
            foreach (Storage::allFiles($perent_dir) as $file){

                $split_file_name = explode("_",basename($file));
                if(count($split_file_name) >= 3) {
                    $action = "";
                    $time = $split_file_name[0];
                    $time = implode("-",[substr($time,0,4), substr($time,4,2),substr($time,6,2)]);
                    $time = strtotime($time);
                    $kategori = $split_file_name[1];
                    $fileName = "";
                    for($index = 2; $index < count($split_file_name); $index++)
                        $fileName.=" ".$split_file_name[$index];

                    $url_delete = '
                        <form class="form-delete-file delete" method="POST" action="' . url($this->base_url) . '">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <input type="hidden" name="bulan" value="' . $request->periode_bulan . '">
                            <input type="hidden" name="tahun" value="' . $request->periode_tahun . '">
                            <input type="hidden" name="path" value="' . $file . '" />
                            <button type="submit" class="btn btn-flat btn-sm btn-danger">' . __('form.button.delete.icon') . '</button>
                        </form>';
                    $action .= $url_delete;

                    $row = [
                        "created_at" => date('d F Y', $time),
                        "category" => $kategori,
                        "file" => '<a href="' . asset(Storage::url($file)) . '" target="_blank">' . $fileName. '</a>',
                        "action" => $action
                    ];
                    array_push($datatable, $row);
                }
            }

            return $dtbHelper->getResult($datatable, count($datatable));

        }catch (\Exception $e){
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }

}