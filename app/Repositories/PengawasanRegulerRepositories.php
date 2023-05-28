<?php

namespace App\Repositories;

use App\Helpers\CostumHelpers;
use App\Helpers\DataTableHelper;
use App\Helpers\VariableHelper;
use App\ItemLingkupPengawasanModel;
use App\LingkupPengawasanModel;
use App\PengawasanRegulerModel;
use App\Report\ExportExcelTindakLanjutPengawasanRegularReport;
use App\Report\ExportReportPengawasanRegulerHawasbid;
use App\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PengawasanRegulerRepositories
{
    private  $base_url;
    private $sector_category, $sector_alias;
    private $sector;
    private $type = "pengawasan-regular";
    private  $opsi_download = "";
    private $kategori = "hawasbid";

    public function __construct($sector_category, $sector_alias){
        $this->sector_category = $sector_category;
        $this->sector_alias = $sector_alias;
        $this->sector = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
    }

    public function setBaseUrl(String $base_url){
        $this->base_url = $base_url;
    }
    public function setType($type){
        $this->type = $type;
    }

    public function setOpsiDownload($opsi_download){
        $this->opsi_download = $opsi_download;
    }

    public function setKategori($kategori){
        $this->kategori = $kategori;
    }

    public function isSectorInArray(Array $sectors){
        if($this->sector == null)
            return false;
        return in_array($this->sector->id, $sectors);
    }

    public function getById($id){
        return PengawasanRegulerModel::where('id',$id)
            ->where('sector_id', $this->sector->id)
            ->first();
    }
    public function getTanggalTindakLanjut($periode_bulan, $periode_tahun){
        $tanggal = date('Y-m-d');
        $query = PengawasanRegulerModel::where('periode_bulan', $periode_bulan)
            ->where('periode_tahun', $periode_tahun)
            ->whereNotNull('tanggal_tindak_lanjut')
            ->orderBy('tanggal_tindak_lanjut','DESC')
            ->first();

        if($query)
            $tanggal = $query->tanggal_tindak_lanjut;

        return $tanggal;
    }
    public function getNamaPenanggungJawab(){
        $nama = "";
        $code = "";
        if($this->sector_category == "kesekretariatan")
            $code = "EMPLOYEEKESEKTARIATANNAME";
        else if($this->sector_category == "kepaniteraan") $code = "EMPLOYEEKEPANITERAANNAME";
        $query = VariableRepositories::getByKey($code);
        if($query)
            $nama = $query->value;
        return $nama;
    }
    public function getNipPenganggungJawab(){
        $nip = "";
        $code = "";
        if($this->sector_category == "kesekretariatan")
            $code = "EMPLOYEEKESEKTARIATANNIP";
        else if($this->sector_category == "kepaniteraan") $code = "EMPLOYEEKEPANITERAANNIP";

        $query = VariableRepositories::getByKey($code);
        if($query)
            $nip = $query->value;
        return $nip;
    }

    public function getJabatanByKategory(){
        $jabatan = "";
        $code = "";
        if($this->sector_category == "kesekretariatan")
            $code = "KESEKTARIATANPOSITIONNAME";
        else if($this->sector_category == "kepaniteraan") $code = "KEPANITERAANPOSITIONNAME";
        $query = VariableRepositories::getByKey($code);
        if($query)
            $jabatan = $query->value;
        return $jabatan;
    }

    public function getByPeriode($periode_bulan, $periode_tahun){
        return ItemLingkupPengawasanModel::with('pengawasan_regular')
            ->whereHas('pengawasan_regular', function ($pengawasan_regular) use($periode_bulan, $periode_tahun) {
                $pengawasan_regular->where('periode_bulan', $periode_bulan)
                    ->where('periode_tahun', $periode_tahun)
                    ->where('sector_id', $this->sector->id);
            })->get();
    }
    public function getPengawasanHawasbid($periode_bulan, $periode_tahun){
        return LingkupPengawasanModel::with(['items' => function($items)  use($periode_bulan, $periode_tahun){
            return $items->with('pengawasan_regular')
                ->whereHas('pengawasan_regular', function ($pengawasan_regular) use($periode_bulan, $periode_tahun){
                    $pengawasan_regular->where('periode_bulan',$periode_bulan)
                        ->where('periode_tahun', $periode_tahun);
                    if($this->opsi_download == "current") {
                        $pengawasan_regular->where('sector_id', $this->sector->id);
                    }else{
                        $pengawasan_regular->whereHas('sectors', function($sector){
                            return $sector->where('category', $this->sector->category);
                        });
                    }
                return $pengawasan_regular;
            });
        }])
        ->whereHas('items', function ($items) use($periode_bulan, $periode_tahun){
            $items->whereHas('pengawasan_regular', function ($pengawasan_regular) use($periode_bulan, $periode_tahun){
                $pengawasan_regular->where('periode_bulan',$periode_bulan)
                    ->where('periode_tahun', $periode_tahun);

                if($this->opsi_download == "current") {
                    $pengawasan_regular->where('sector_id', $this->sector->id);
                }else{
                    $pengawasan_regular->whereHas('sectors', function($sector){
                        return $sector->where('category', $this->sector->category);
                    });
                }
                return $pengawasan_regular;
            });
            return $items;
        })->get();
    }

    public function getDataTable(Request $request){
        $dtbHelper = new DataTableHelper($request);
        $params = $dtbHelper->getParams();
        $total = $this->getTotalDatatable($params);
        $data = $this->generateDataDatatable($params);
        return $dtbHelper->getResult($data, $total);
    }

    public function getTotalDatatable(array $params){
        $query = DB::table('pengawasan_regular')
            ->join('item_lingkup_pengawasan','item_lingkup_pengawasan_id','=','item_lingkup_pengawasan.id')
            ->join('lingkup_pengawasan','lingkup_pengawasan_id','=','lingkup_pengawasan.id')
            ->where('sector_id',$this->sector->id);

        if(count($params['searchByColumn']) >0){
            foreach ($params['searchByColumn'] as $column)
                $query->where($column,'like','%'.$params['searchQuery'].'%');
        }
        return $query->count();
    }

    public function generateDataDatatable(array $params){
        $resultData = $this->getDataDatatable($params);
        $dataTable = array();
        $no = 1;
        foreach ($resultData as $row){
            $action = "";
            if($this->type == "pengawasan-regular") {
                $url_view = '<a href="' . url($this->base_url . "/" . $row->id) . '" class="btn btn-sm btn-flat btn-success mr-1 ml-1">' . __('form.button.view.icon') . '</a>';
                $url_edit = '<a href="' . url($this->base_url . "/" . $row->id . '/edit') . '" class="btn btn-sm btn-flat btn-warning mr-1 ml-1">' . __('form.button.edit.icon') . '</a>';
                $url_delete = '<a href="' . url($this->base_url . "/" . $row->id) . '" class="btn-link-delete btn btn-sm btn-flat btn-danger mr-1 ml-1">' . __('form.button.delete.icon') . '</a>';

                $action .= $url_view;
                $action .= $url_edit;
                $action .= $url_delete;
            }else
                $action = '<a href="' . url($this->base_url . "/" . $row->id . '/edit') . '" class="btn btn-sm btn-flat btn-warning mr-1 ml-1">' . __('form.button.edit.icon') . '</a>';

            $status = '<h5><span class="badge" style="padding: 5px;background-color: '.$row->background_color.'; color: '.$row->text_color.'" data-toggle="tooltip" data-placement="top" title="'.$row->status_pengawasan_regular_nama.'">'.$row->icon.'</span></h5>';


            $dataRow = [
                "no"                            => $no,
                "lingkup_pengawasan_nama"       => $row->lingkup_pengawasan_nama,
                "item_lingkup_pengawasan_nama"  => $row->item_lingkup_pengawasan_nama,
                "periode_tahun"                   => $row->periode_tahun,
                "periode_bulan"                   => $row->periode_bulan,
                "temuan"                        => str_limit(strip_tags($row->temuan), 100, ' ...'),
                "status"                        => $status,
                "created_at"                    => date('d F Y',strtotime($row->created_at)),
                "action"                        => $action
            ];
            $no+=1;
            array_push($dataTable, $dataRow);
        }
        return $dataTable;
    }

    public function getDataDatatable(array $params){
        $query = DB::table('pengawasan_regular')
            ->select('pengawasan_regular.*',
                'status_pengawasan_regular.nama as status_pengawasan_regular_nama','status_pengawasan_regular.text_color',
                'status_pengawasan_regular.background_color','status_pengawasan_regular.icon',
                'item_lingkup_pengawasan.nama as item_lingkup_pengawasan_nama','lingkup_pengawasan.nama as lingkup_pengawasan_nama')
            ->join('item_lingkup_pengawasan','item_lingkup_pengawasan_id','=','item_lingkup_pengawasan.id')
            ->join('lingkup_pengawasan','lingkup_pengawasan_id','=','lingkup_pengawasan.id')
            ->join('status_pengawasan_regular','status_pengawasan_regular_id','=','status_pengawasan_regular.id')
            ->where('sector_id',$this->sector->id);
        if(count($params['searchByColumn']) >0){
            $query->where(function($q) use($params){
                foreach ($params['searchByColumn'] as $column)
                    $q->orWhere($column,'like','%'.$params['searchQuery'].'%');
                return $q;
            });
        }
        if(count($params['orders']) >0){
            foreach ($params['orders'] as $column)
                $query->orderBy($column[0],$column[1]);
        }
        $query->offset($params['start'])
            ->limit($params['limit']);
        return $query->get();
    }

    public function store(Request  $request){
        DB::beginTransaction();
        try {
            $model = new PengawasanRegulerModel;
            $model->periode_tahun = $request->periode_tahun;
            $model->periode_bulan = $request->peride_bulan;
            $model->sector_id = $this->sector->id;
            $model->item_lingkup_pengawasan_id  = $request->item_lingkup_pengawasan_id;
            $model->title = $request->title;
            $model->temuan = $request->temuan;
            $model->kriteria = $request->kriteria;
            $model->sebab = $request->sebab;
            $model->akibat = $request->akibat;
            $model->rekomendasi = $request->rekomendasi;
            $model->tanggal_rapat_hawasbid = $request->tanggal_rapat_hawasbid;
            $model->status_pengawasan_regular_id = "SUBMITEDBYHAWASBID";
            $model->save();

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Input data berhasil'
            ], 200);
        }catch (\Exception $e){
            DB::rollBack();
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }

    public function update($id, Request  $request){
        DB::beginTransaction();
        try {
            $model = $this->getById($id);
            $model->periode_tahun = $request->periode_tahun;
            $model->periode_bulan = $request->peride_bulan;
            $model->item_lingkup_pengawasan_id  = $request->item_lingkup_pengawasan_id;
            $model->temuan = $request->temuan;
            $model->kriteria = $request->kriteria;
            $model->sebab = $request->sebab;
            $model->akibat = $request->akibat;
            $model->rekomendasi = $request->rekomendasi;
            $model->tanggal_rapat_hawasbid = $request->tanggal_rapat_hawasbid;
            $model->save();

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Update data berhasil'
            ], 200);
        }catch (\Exception $e){
            DB::rollBack();
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }

    public function updateUraian($id, Request  $request){
        $user_level = Auth::user()->user_level;
        DB::beginTransaction();
        try {
            if ($this->sector) {
                $costumHelper = new CostumHelpers();
                $model = PengawasanRegulerModel::where("sector_id", $this->sector->id)
                    ->where('id', $id)->first();

                if ($model == null)
                    throw new \Exception("Gagal memperbaharui data",400);


                $dir = "public/pengawasan-reguler/" . $this->sector_alias."/".$model->id;
                $files = $request->file('files');
                $costumHelper->uploadToStorage($dir, $files);

                $files = Storage::allFiles($dir);
                $total_files = count($files);
                if($request->uncheckedfiles != null)
                    foreach ($request->uncheckedfiles as $file){
                        if(in_array($file,$files)){
                            Storage::delete($file);
                            $total_files -= 1;
                        }
                    }

                $model->uraian = $request->uraian;
                $model->total_evidence = $total_files;
                $model->tanggal_tindak_lanjut = $request->tanggal_tindak_lanjut;
                if(count($files) > 0 && $request->uraian !== null && $model->status_pengawasan_regular_id == "SUBMITEDBYHAWASBID")
                    $model->status_pengawasan_regular_id = "WAITINGAPPROVALFROMADMIN";

                if($user_level->alias == "admin") {
                    if ($request->status_pengawasan_regular_id) {
                        $model->status_pengawasan_regular_id = $request->status_pengawasan_regular_id;
                    }
                }

                $model->save();

                DB::commit();
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Update data berhasil'
                ], 200);
            }else{
                throw new \Exception("Gagal memperbaharui data",400);
            }
        }catch (\Exception $e){
            DB::rollBack();
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }

    }

    public function delete($id){
        DB::beginTransaction();
        try {
            PengawasanRegulerModel::where('id',$id)
                ->where('sector_id', $this->sector->id)
                ->delete();
            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Berhasil data berhasil'
            ], 200);
        }catch (\Exception $e){
            DB::rollBack();
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }

    public function uploadTemplate(Request  $request){
        try {
            if ($this->sector == null)
                throw new \Exception("Terjadi kesahalan. Harap muat ulang halaman anda",400);

            $template_name = "template_pr_hawasbid_".$this->sector_category."_".$this->sector_alias.'.docx';
            $template_path_save = "public/report/template";

            $request->file('file-template')->storeAs($template_path_save,$template_name);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Berhasil mengupload file template'
            ], 200);
        }catch (\Exception $e){
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }

    public function getReportTemplateName(){
        return "template_pr_".$this->kategori."_".$this->sector_category."_".$this->sector_alias.".docx";
    }

    public function getReportTemplateUrl(){
        return asset(Storage::url(ExportReportPengawasanRegulerHawasbid::$template_path."/".$this->getReportTemplateName()));
    }

    public function isTemplateWordAvaible(){
        if(!Storage::exists(ExportReportPengawasanRegulerHawasbid::$template_path."/".$this->getReportTemplateName()))
            return false;
        return true;
    }

    public function exportReportWord(Request $request){
        $export = new ExportReportPengawasanRegulerHawasbid();
        $template_name = $this->getReportTemplateName();
        $periode = $request->periode_tahun."-".$request->periode_bulan;
        try{

            $kesesuaianPengawasanRegulerRepo = new KesesuaianPengawasanRegulerRepositories($this->sector_category, $this->sector_alias);
            $kesesuaianByPeriode = $kesesuaianPengawasanRegulerRepo->getByPeriodeFromItem($request->periode_bulan,$request->periode_tahun);
            $temuanByPeriode = $this->getByPeriode($request->periode_bulan, $request->periode_tahun);

            $export->setKesesuaian($kesesuaianByPeriode);
            $export->setTemuan($temuanByPeriode);
            $export->setFilename(date('ymdHis')."docx");
            $export->setSectorName($this->sector_alias);
            $export->setTemplateName($template_name);
            $export->setPeriode($request->periode_bulan,$request->periode_tahun);
            $pth_export_file =  $export->exportWord();
            $zip = new ZipArchive();
            $zip_pth_location = Storage::url("public/temp_zip_download/".basename($pth_export_file,".docx").".zip");
            $zip->open(public_path($zip_pth_location), ZipArchive::CREATE);
            $zip->addFile(public_path(Storage::url($pth_export_file)),basename($pth_export_file));
            $this->addDocumentationToZip($periode,$zip);
            $zip->close();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Berhasil data berhasil',
                'path_download' => asset($zip_pth_location)
            ], 200);
        }catch (\Exception $e){
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }

    function addEvidenceToZip($listId,ZipArchive $zip){
        $baseDir = "public/pengawasan-reguler/" . $this->sector_alias."/";
        foreach ($listId as $id){
            $dir = $baseDir.strval($id);
            $listFiles = Storage::allFiles($dir);
            foreach ($listFiles as $file){
                $zip->addFile(public_path(Storage::url($file)), "evidence/".$id."_".basename($file));
            }
        }
    }
    function addDocumentationToZip($periode, ZipArchive $zip){
        $perent_dir = "public/pengawasan-reguler/" . $this->sector_alias . "/dokumentasi-rapat/".$periode."/".$this->kategori;
        foreach (Storage::directories($perent_dir) as $dir_time) {
            $dir_time_segment = explode("/",$dir_time);
            $time = array_pop($dir_time_segment);
            foreach (Storage::directories($dir_time) as $dir_category){
                $dir_category_secment = explode("/",$dir_category);
                $kategori = array_pop($dir_category_secment);
                foreach (Storage::allFiles($dir_category) as $file){
                    $zip->addFile(public_path(Storage::url($file)),"documentations/$kategori/".$time."_".basename($file));
                }
            }
        }
    }

    public function exportExcelTindakLanjutReport(Request $request){
        try{
            if ($this->sector == null)
                throw new \Exception("Data tidak ditemukan", 400);
            $periode =  $request->periode_tahun."-".$request->periode_bulan;
            $periodeName = VariableHelper::getMonthName($request->periode_bulan)." ".$request->periode_tahun;
            $export = new ExportExcelTindakLanjutPengawasanRegularReport();
            $fname = time()."_tindaklanjut_pr_".$this->sector_category."_".$this->sector_alias."_".$request->periode_tahun.$request->periode_bulan;
            $data = $this->getPengawasanHawasbid($request->periode_bulan, $request->periode_tahun);
            $tglTindakLanjut = $this->getTanggalTindakLanjut($request->periode_bulan, $request->periode_tahun);
            $namaPenanggungJawab = $this->getNamaPenanggungJawab();
            $nipPenanggungJawab = $this->getNipPenganggungJawab();
            $jabatan = $this->getJabatanByKategory();

            $export->setPathSaveName($fname);
            $export->setPeriode($periodeName);
            $export->setData($data);
            $export->setTglTindakLanjut($tglTindakLanjut);
            $export->setNipPenganggungJawab($nipPenanggungJawab);
            $export->setNamaPenganggungJawab($namaPenanggungJawab);
            $export->setJabatanPenganggungJawab($jabatan);
            $export->run();

            $file_Excel_location = $export->getPathSaveLocation()."/".$fname.".xlsx";
            $zip = new ZipArchive();
            $zip_pth_location = Storage::url("public/temp_zip_download/".basename($file_Excel_location,".xlsx").".zip");
            $zip->open(public_path($zip_pth_location), ZipArchive::CREATE);
            $zip->addFile(public_path($file_Excel_location),basename($file_Excel_location));
            $this->addDocumentationToZip($periode,$zip);
            $this->addEvidenceToZip($export->getListIdTindakLanjut(),$zip);
            $zip->close();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Berhasil data berhasil',
                'path_download' => asset($zip_pth_location)
            ], 200);
        }catch (\Exception $e){
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }
}