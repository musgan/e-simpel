<?php

namespace App\Repositories;

use App\Helpers\DataTableHelper;
use App\ItemLingkupPengawasanModel;
use App\LingkupPengawasanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LingkupPengawasanRepositories
{
    private $base_url;
    public function __construct(String $base_url)
    {
        $this->base_url = $base_url;
    }

    public function getAll(){
        return LingkupPengawasanModel::all();
    }


    public function getDataTable(Request $request){
        $dtbHelper = new DataTableHelper($request);
        $params = $dtbHelper->getParams();
        $total = $this->getTotalDatatable($params);
        $data = $this->generateDataDatatable($params);
        return $dtbHelper->getResult($data, $total);
    }

    public function getTotalDatatable(array $params){
        $query = LingkupPengawasanModel::select("*");
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
                "nama"          => $row->nama,
                "created_at"    => date('d F Y',strtotime($row->created_at)),
                "action"        => $action
            ];
            $no+=1;
            array_push($dataTable, $dataRow);
        }
        return $dataTable;
    }

    public function getDataDatatable(array $params){
        $query = LingkupPengawasanModel::select("*");
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

    public function getById($id){
        return LingkupPengawasanModel::findOrFail($id);
    }


    public function store(Request  $request){
        DB::beginTransaction();
        try {
            $lingkup_pengawasan_id = $this->storeLingkupPengawasan($request);
            $this->storeItemLingkupPengawasan($lingkup_pengawasan_id, $request);
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

    private function storeLingkupPengawasan(Request $request){
        $save_lingkup_pengawasan = new LingkupPengawasanModel;
        $save_lingkup_pengawasan->nama = $request->name;
        $save_lingkup_pengawasan->save();
        return $save_lingkup_pengawasan->id;
    }
    private function storeItemLingkupPengawasan($lingkup_pengawasan_id, Request  $request){
        $array = array();
        foreach (explode(",",$request->id_items) as $index){
            if(strlen($request->id[$index]) == 0) {
                $item = [
                    'lingkup_pengawasan_id' => $lingkup_pengawasan_id,
                    'nama' => $request->item[$index],
                    'created_at'    => date('Y-m-d H:i:s')
                ];
                array_push($array, $item);
            }
        }
        ItemLingkupPengawasanModel::insert($array);
    }



    private function updateLingkupPengawasan($id, Request $request){
        $save_lingkup_pengawasan = LingkupPengawasanModel::findOrFail($id);
        $save_lingkup_pengawasan->nama = $request->name;
        $save_lingkup_pengawasan->save();
    }
    function deleteItemLingkupPengawasan( $lingkup_pengawasan_id, Request $request){
        $array = array();
        foreach (explode(",",$request->id_items) as $index){
            $id = $request->id[$index];
            if($request->is_delete[$index] == true && strlen($id) > 0) {
                array_push($array, $id);
            }
        }
        ItemLingkupPengawasanModel::whereIn('id',$array)
            ->where('lingkup_pengawasan_id',$lingkup_pengawasan_id)
            ->delete();
    }
    function updateItemLingkupPengawasan( $lingkup_pengawasan_id, Request $request){
        foreach (explode(",",$request->id_items) as $index){
            $id = $request->id[$index];
            if($request->is_delete[$index] !== true && strlen($id) > 0) {
                ItemLingkupPengawasanModel::where('lingkup_pengawasan_id',$lingkup_pengawasan_id )
                    ->where('id',$id)
                    ->update([
                        'nama'  => $request->item[$index]
                    ]);
            }
        }
    }

    public function update($id, Request $request){
        DB::beginTransaction();
        try{

            $this->updateLingkupPengawasan($id, $request);
//            add when have new item
            $this->storeItemLingkupPengawasan($id,   $request);
            $this->updateItemLingkupPengawasan( $id, $request);
            $this->deleteItemLingkupPengawasan($id, $request);

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
        try{
            LingkupPengawasanModel::findOrFail($id)->delete();
            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Berhasil menghapus data'
            ], 200);
        }catch (\Exception $e){
            DB::rollBack();
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
            return response()->json($e->getMessage(), $e->getCode());
            }else return abort(500,$e->getMessage());
        }
    }
}