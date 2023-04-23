<?php

namespace App\Repositories;

use App\Helpers\DataTableHelper;
use App\LingkupPengawasanBidangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LingkupPengawasanBidangRepositories
{
    private $base_url = "";
    public function getDataTable(Request $request){
        $dtbHelper = new DataTableHelper($request);
        $params = $dtbHelper->getParams();
        $total = $this->getTotalDatatable($params);
        $data = $this->generateDataDatatable($params);
        return $dtbHelper->getResult($data, $total);
    }

    public function getTotalDatatable(array $params){
        $query = DB::table('lingkup_pengawasan_bidang')
            ->join('item_lingkup_pengawasan','item_lingkup_pengawasan_id','=','item_lingkup_pengawasan.id')
            ->join('lingkup_pengawasan','lingkup_pengawasan_id','=','lingkup_pengawasan.id')
            ->join('sectors','sector_id','=','sectors.id');

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
//            $url_view = '<a href="'.url($this->base_url."/".$row->id).'" class="btn btn-sm btn-flat btn-success mr-1 ml-1">'.__('form.button.view.icon').'</a>';
            $url_edit = '<a href="'.url($this->base_url."/".$row->sector_id.'/edit').'" class="btn btn-sm btn-flat btn-warning mr-1 ml-1">'.__('form.button.edit.icon').'</a>';
//            $url_delete = '<a href="'.url($this->base_url."/".$row->id).'" class="btn-link-delete btn btn-sm btn-flat btn-danger mr-1 ml-1">'.__('form.button.delete.icon').'</a>';

//            $action .= $url_view;
            $action .= $url_edit;
//            $action .= $url_delete;

            $dataRow = [
                "no"                            => $no,
                "lingkup_pengawasan_nama"       => $row->lingkup_pengawasan_nama,
                "item_lingkup_pengawasan_nama"  => $row->item_lingkup_pengawasan_nama,
                "sector_nama"                   => $row->sector_nama,
                "created_at"                    => date('d F Y',strtotime($row->created_at)),
                "action"                        => $action
            ];
            $no+=1;
            array_push($dataTable, $dataRow);
        }
        return $dataTable;
    }

    public function getDataDatatable(array $params){
        $query = DB::table('lingkup_pengawasan_bidang')
            ->select('lingkup_pengawasan_bidang.*','lingkup_pengawasan.nama as lingkup_pengawasan_nama','item_lingkup_pengawasan.nama as item_lingkup_pengawasan_nama','sectors.nama as sector_nama','sectors.id as sector_id')
            ->join('item_lingkup_pengawasan','item_lingkup_pengawasan_id','=','item_lingkup_pengawasan.id')
            ->join('lingkup_pengawasan','lingkup_pengawasan_id','=','lingkup_pengawasan.id')
            ->join('sectors','sector_id','=','sectors.id');
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

    public function getLingkupPengawasanBidang($sector_id){
        return LingkupPengawasanBidangModel::where('sector_id', $sector_id)->get();
    }

    public static function store(Request $request){
        DB::beginTransaction();
        try{
            $array = array();
            foreach ($request->lingkup_pengawasan_id as $id) {
                $data = [
                    'item_lingkup_pengawasan_id'    => $id,
                    'sector_id' => $request->sector_id,
                    'created_at'    => date('Y-m-d H:i:s')
                ];
                array_push($array, $data);
            }
            LingkupPengawasanBidangModel::insert($array);

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

    function deleteNotIn($sector_id,array $lingkup_pengawasan){
        LingkupPengawasanBidangModel::whereNotIn('item_lingkup_pengawasan_id', $lingkup_pengawasan)
            ->where('sector_id', $sector_id)
            ->delete();
    }
    function addNotIn($sector_id, array $lingkup_pengawasan){
        $lp_bidang = $this->getLingkupPengawasanBidang($sector_id);
        $array_current_item = array();
        $array = array();

        foreach ($lp_bidang as $row){
            array_push($array_current_item, $row->item_lingkup_pengawasan_id );
        }

        foreach ($lingkup_pengawasan as $new_item){
            if(!in_array($new_item, $array_current_item)){
                $data = [
                    'item_lingkup_pengawasan_id'    => $new_item,
                    'sector_id' => $sector_id,
                    'created_at'    => date('Y-m-d H:i:s')
                ];
                array_push($array, $data);
            }
        }
        if (count($array) > 0)
            LingkupPengawasanBidangModel::insert($array);
    }

    public function update($ector_id, Request $request){
        DB::beginTransaction();
        try{
            $this->deleteNotIn($ector_id, $request->lingkup_pengawasan_id);
            $this->addNotIn($ector_id, $request->lingkup_pengawasan_id);
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

    public function setBaseUrl(String $base_url){
        $this->base_url = $base_url;
    }
}