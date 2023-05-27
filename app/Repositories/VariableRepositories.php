<?php

namespace App\Repositories;

use App\Helpers\DataTableHelper;
use App\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariableRepositories
{
    private $base_url;
    public function setBaseUrl($base_url){
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
        $query = Variable::select("*");
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
            $url_edit = '<a href="'.url($this->base_url."/".$row->key.'/edit').'" class="btn btn-sm btn-flat btn-warning mr-1 ml-1">'.__('form.button.edit.icon').'</a>';
            $action .= $url_edit;

            $dataRow = [
                "no"            => $no,
                "key"           => $row->key,
                "value"         => $row->value,
                "keterangan"    => $row->keterangan,
                "action"        => $action
            ];
            $no+=1;
            array_push($dataTable, $dataRow);
        }
        return $dataTable;
    }

    public function getDataDatatable(array $params){
        $query = Variable::select("*");
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

    public static function getByKey($key){
        return Variable::where('key', $key)->first();
    }

    public function update($key, Request $request){
        DB::beginTransaction();
        try{
            $model = Variable::where('key', $key)->first();
            $model->value = $request->value;
            $model->keterangan = $request->keterangan;
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
}