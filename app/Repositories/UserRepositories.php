<?php

namespace App\Repositories;

use App\Helpers\DataTableHelper;
use App\LingkupPengawasanModel;
use App\User;
use Illuminate\Http\Request;

class UserRepositories
{
    private $base_url;
    public function __construct()
    {
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
        $query =  User::select('users.id','users.name','users.email','user_levels.nama as nama_level')
            ->join('user_levels','user_levels.id','=','user_level_id');
        if(count($params['searchByColumn']) >0){
            foreach ($params['searchByColumn'] as $column)
                $query->where($column,'like','%'.$params['searchQuery'].'%');
        }
        return $query->count();
    }

    public function generateDataDatatable(array $params){
        $resultData = $this->getDataDatatable($params);
        $dataTable = array();
        $no = $params['start']+1;
        foreach ($resultData as $row){
            $action = "";
            $url_edit = '<a href="'.url($this->base_url."/".$row->id.'/edit').'" class="btn btn-sm btn-flat btn-warning mr-1 ml-1">'.__('form.button.edit.icon').'</a>';
            $url_delete = '<a href="'.url($this->base_url."/".$row->id).'" class="btn-link-delete btn btn-sm btn-flat btn-danger mr-1 ml-1">'.__('form.button.delete.icon').'</a>';

            $action .= $url_edit;
            $action .= $url_delete;

            $dataRow = [
                "no"            => $no,
                "name"          => $row->name,
                "email"          => $row->email,
                "nama_level"          => $row->nama_level,
                "action"        => $action
            ];
            $no+=1;
            array_push($dataTable, $dataRow);
        }
        return $dataTable;
    }

    public function getDataDatatable(array $params){
        $query = User::select('users.id','users.name','users.email','user_levels.nama as nama_level')
            ->join('user_levels','user_levels.id','=','user_level_id');
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
}