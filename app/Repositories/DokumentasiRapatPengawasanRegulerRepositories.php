<?php

namespace App\Repositories;

use App\Helpers\CostumHelpers;
use App\Helpers\DataTableHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DokumentasiRapatPengawasanRegulerRepositories
{
    private  $base_url;
    private $sector_category, $sector_alias;
    private $sector;
    private $kategori = "hawasbid";
    private $isAuthorizeToAction;
    public function __construct($sector_category, $sector_alias){
        $this->sector_category = $sector_category;
        $this->sector_alias = $sector_alias;
        $this->sector = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
        $this->isAuthorizeToAction = Gate::allows("pengawasan-hawasbid",[$sector_category,$sector_alias]);
    }

    public function setBaseUrl(String $base_url){
        $this->base_url = $base_url;
    }
    public function setKategori($kategori){
        $this->kategori = $kategori;
        if($kategori == "tindak-lanjut")
            $this->isAuthorizeToAction = Gate::allows("pengawasan-tl",[$this->sector_category,$this->sector_alias]);
    }

    public function getDataTableArray(Request  $request){
        $dtbHelper = new DataTableHelper($request);
        $hasAction = true;
        try{
            SettingPeriodeRepositories::isTindakLanjutAvaibleToupdate($this->kategori,
                $request->periode_tahun,
                $request->periode_bulan);
            SettingPeriodeRepositories::isHawasbidAvaibleToupdate($this->kategori,
                $request->periode_tahun,
                $request->periode_bulan);
        }catch (\Exception $e){
            $hasAction = false;
        }

        try {
            if($request->periode_bulan == null || $request->periode_tahun == null)
                throw new \Exception("Anda harus memilih periode",400);
            $datatable = array();

            $periode = $request->periode_tahun."-".$request->periode_bulan;
            $perent_dir = "public/pengawasan-reguler/" . $this->sector_alias . "/dokumentasi-rapat/".$periode."/".$this->kategori;
            foreach (Storage::directories($perent_dir) as $dir_time){
                $dir_time_segment = explode("/",$dir_time);
                $time = array_pop($dir_time_segment);
                foreach (Storage::directories($dir_time) as $dir_category){
                    $dir_category_secment = explode("/",$dir_category);
                    $kategori = array_pop($dir_category_secment);
                    foreach (Storage::allFiles($dir_category) as $file){

                        $action = "";
                        $url_delete = '
                        <form class="form-delete-file" method="POST" action="'.url($this->base_url).'">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <input type="hidden" name="periode" value="'.$periode.'">
                            <input type="hidden" name="time" value="'.$time.'" />
                            <input type="hidden" name="kategori" value="'.$this->kategori.'" />
                            <input type="hidden" name="filename" value="'.basename($file).'">
                            <input type="hidden" name="category" value="'.$kategori.'">
                            <button type="submit" class="btn btn-flat btn-sm btn-danger">'.__('form.button.delete.icon').'</button>
                        </form>';

                        if($hasAction && $this->isAuthorizeToAction)
                            $action .= $url_delete;

                        $row  = [
                            "created_at"   =>  date('d F Y',$time),
                            "category"  => $kategori,
                            "file"  => '<a href="'.asset(Storage::url($file)).'" target="_blank">'.basename($file).'</a>',
                            "action"  => $action
                        ];
                        array_push($datatable, $row);
                    }
                }
            }

            return $dtbHelper->getResult($datatable, count($datatable));

        }catch (\Exception $e){
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }

    public function store(Request $request){
        try {
            if ($this->sector == null)
                throw new \Exception("Gagal menyimpan dokumentasi rapat",400);

            $costumHelper = new CostumHelpers();
            $periode = $request->periode_tahun."-".$request->periode_bulan;
            $dir = "public/pengawasan-reguler/" . $this->sector_alias . "/dokumentasi-rapat/".$periode."/".$this->kategori.'/'.time();

            $dir_notulensi = $dir."/notulensi";
            $dir_absensi = $dir."/absensi";
            $dir_foto = $dir."/foto";

            $costumHelper->uploadToStorage($dir_notulensi, $request->file('notulensi'));
            $costumHelper->uploadToStorage($dir_absensi, $request->file('absensi'));
            $costumHelper->uploadToStorage($dir_foto, $request->file('foto'));

            return response()->json([
                'status'    => 'success',
                'message'   => 'Berhasil menambah data dokumentasi'
            ], 200);
        }catch (\Exception $e){
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }

    public function delete(Request $request){
        try {
            if ($this->sector == null)
                throw new \Exception("Gagal menghapus file", 400);
            $filepath = "public/pengawasan-reguler/" . $this->sector_alias . "/dokumentasi-rapat/".
                $request->periode."/".$this->kategori.'/'.$request->time.'/'.$request->category.'/'.$request->filename;
            Storage::delete($filepath);
            return response()->json([
                'status'    => 'success',
                'message'   => 'Berhasil menghapus data dokumentasi'
            ], 200);
        }catch (\Exception $e){
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }
}