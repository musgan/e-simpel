<?php
namespace App\Repositories;

use App\Helpers\DataTableHelper;
use App\KesesuaianPengawasanRegularModel;
use App\LingkupPengawasanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KesesuaianPengawasanRegulerRepositories
{
    private $sector_category, $sector_alias;
    private $sector;
    private  $base_url;

    public function __construct($sector_category, $sector_alias){
        $this->sector_category = $sector_category;
        $this->sector_alias = $sector_alias;
        $this->sector = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
    }

    public function setBaseUrl(String $base_url){
        $this->base_url = $base_url;
    }

    public function getDataTable(Request $request){
        $dtbHelper = new DataTableHelper($request);
        $params = $dtbHelper->getParams();
        $total = $this->getTotalDatatable($params);
        $data = $this->generateDataDatatable($params);
        return $dtbHelper->getResult($data, $total);
    }

    public function getTotalDatatable(array $params){
        $query = KesesuaianPengawasanRegularModel::select("*")
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
            $url_view = '<a href="'.url($this->base_url."/".$row->id).'" class="btn btn-sm btn-flat btn-success mr-1 ml-1">'.__('form.button.view.icon').'</a>';
            $url_edit = '<a href="'.url($this->base_url."/".$row->id.'/edit').'" class="btn btn-sm btn-flat btn-warning mr-1 ml-1">'.__('form.button.edit.icon').'</a>';
            $url_delete = '<a href="'.url($this->base_url."/".$row->id).'" class="btn-link-delete btn btn-sm btn-flat btn-danger mr-1 ml-1">'.__('form.button.delete.icon').'</a>';

            $action .= $url_view;
            $action .= $url_edit;
            $action .= $url_delete;

            $dataRow = [
                "no"            => $no,
                "periode_tahun"          => $row->periode_tahun,
                "periode_bulan"          => $row->periode_bulan,
                "uraian"          => str_limit(strip_tags($row->uraian), 300, ' ...'),
                "created_at"    => date('d F Y',strtotime($row->created_at)),
                "action"        => $action
            ];
            $no+=1;
            array_push($dataTable, $dataRow);
        }
        return $dataTable;
    }

    public function getDataDatatable(array $params){
        $query = KesesuaianPengawasanRegularModel::select("*")
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

    public function getById($id){
        return KesesuaianPengawasanRegularModel::where('id', $id)
            ->where('sector_id', $this->sector->id)
            ->first();
    }

    public function getByPeriode($periode_bulan, $periode_tahun){
        return KesesuaianPengawasanRegularModel::where('sector_id', $this->sector->id)
            ->where('periode_bulan', $periode_bulan)
            ->where('periode_tahun',$periode_tahun)
            ->first();
    }

    public function checkAvaibleData($periode_bulan, $periode_tahun){
        $model = $this->getByPeriode($periode_bulan, $periode_tahun);
        if($model !== null)
            throw new \Exception("Telah ada data sebelumnya berdasarkan periode yang digunakan. Harap gunakan periode lain",
                400);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $this->checkAvaibleData($request->peride_bulan, $request->periode_tahun);
            $model = new KesesuaianPengawasanRegularModel;
            $model->sector_id = $this->sector->id;
            $model->uraian = $request->uraian_kesesuaian;
            $model->periode_tahun = $request->periode_tahun;
            $model->periode_bulan = $request->peride_bulan;
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

    public function update($id,Request $request){
        DB::beginTransaction();
        try {
            $model = KesesuaianPengawasanRegularModel::where('id',$id)
                ->where('sector_id', $this->sector->id)->first();
            $model->uraian = $request->uraian_kesesuaian;
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

    public function delete($id){
        DB::beginTransaction();
        try {
            KesesuaianPengawasanRegularModel::where('sector_id',$this->sector->id)
                ->where('id', $id)
                ->delete();

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Hapus data berhasil'
            ], 200);
        }catch (\Exception $e){
            DB::rollBack();
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }
}