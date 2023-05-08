<?php

namespace App\Repositories;

use App\ExportReportPengawasanRegulerHawasbid;
use App\Helpers\CostumHelpers;
use App\Helpers\DataTableHelper;
use App\Helpers\VariableHelper;
use App\PengawasanRegulerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengawasanRegulerRepositories
{
    private  $base_url;
    private $sector_category, $sector_alias;
    private $sector;
    private $type = "pengawasan-regular";
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

    public function setKategori($kategori){
        $this->kategori = $kategori;
    }

    public function getById($id){
        return PengawasanRegulerModel::where('id',$id)
            ->where('sector_id', $this->sector->id)
            ->first();
    }

    public function getByPeriode($periode_bulan, $periode_tahun){
        return PengawasanRegulerModel::where('periode_bulan', $periode_bulan)
            ->where('periode_tahun', $periode_tahun)
            ->where('sector_id',$this->sector->id)
            ->get();
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
            foreach ($params['searchByColumn'] as $column)
                $query->where($params,'like','%'.$params['searchQuery'].'%');
        }
        if(count($params['orders']) >0){
            foreach ($params['orders'] as $column)
                $query->orderBy($column[0],$column[1]);
        }
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
            $model->temuan = $request->temuan;
            $model->kriteria = $request->kriteria;
            $model->sebab = $request->sebab;
            $model->akibat = $request->akibat;
            $model->rekomendasi = $request->rekomendasi;
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
            $model->temuan = $request->temuan;
            $model->kriteria = $request->kriteria;
            $model->sebab = $request->sebab;
            $model->akibat = $request->akibat;
            $model->rekomendasi = $request->rekomendasi;
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

    public function exportReportWord(Request $request){
        $export = new ExportReportPengawasanRegulerHawasbid();
        $template_name = "template_pr_".$this->kategori."_".$this->sector_category."_".$this->sector_alias.".docx";
        try{

            $kesesuaianPengawasanRegulerRepo = new KesesuaianPengawasanRegulerRepositories($this->sector_category, $this->sector_alias);
            $kesesuaianByPeriode = $kesesuaianPengawasanRegulerRepo->getByPeriode($request->periode_bulan,$request->periode_tahun);
            $temuanByPeriode = $this->getByPeriode($request->periode_bulan, $request->periode_tahun);

            $export->setKesesuaian($kesesuaianByPeriode);
            $export->setTemuan($temuanByPeriode);
            $export->setFilename(date('ymdHis')."docx");
            $export->setSectorName($this->sector_alias);
            $export->setTemplateName($template_name);
            $pth_export_file =  $export->exportWord();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Berhasil data berhasil',
                'path_download' => asset(Storage::url($pth_export_file))
            ], 200);
        }catch (\Exception $e){
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }
}