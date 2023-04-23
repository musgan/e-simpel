<?php

namespace App\Repositories;

use App\Helpers\DataTableHelper;
use App\Helpers\VariableHelper;
use App\PengawasanRegulerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengawasanRegulerRepositories
{
    private  $base_url;
    private $sector_category, $sector_alias;
    private $sector;
    public function __construct($sector_category, $sector_alias){
        $this->sector_category = $sector_category;
        $this->sector_alias = $sector_alias;
        $this->sector = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
    }

    public function setBaseUrl(String $base_url){
        $this->base_url = $base_url;
    }

    public function getById($id){
        return PengawasanRegulerModel::where('id',$id)
            ->where('sector_id', $this->sector->id)
            ->first();
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
            $url_view = '<a href="'.url($this->base_url."/".$row->id).'" class="btn btn-sm btn-flat btn-success mr-1 ml-1">'.__('form.button.view.icon').'</a>';
            $url_edit = '<a href="'.url($this->base_url."/".$row->id.'/edit').'" class="btn btn-sm btn-flat btn-warning mr-1 ml-1">'.__('form.button.edit.icon').'</a>';
            $url_delete = '<a href="'.url($this->base_url."/".$row->id).'" class="btn-link-delete btn btn-sm btn-flat btn-danger mr-1 ml-1">'.__('form.button.delete.icon').'</a>';

            $action .= $url_view;
            $action .= $url_edit;
            $action .= $url_delete;

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
}