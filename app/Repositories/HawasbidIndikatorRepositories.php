<?php

namespace App\Repositories;

use App\Helpers\DataTableHelper;
use App\Helpers\VariableHelper;
use App\LingkupPengawasanModel;
use App\Secretariat;
use Illuminate\Http\Request;

class HawasbidIndikatorRepositories
{
    private $base_url = "";

    public function setBaseUrl($base_url){
        $this->base_url = $base_url;
    }

    public function getDataTable(Request $request){
        $dtbHelper = new DataTableHelper($request);
        $params = $dtbHelper->getParams();
        $params["periode_bulan"] = $request->periode_bulan;
        $params["periode_tahun"] = $request->periode_tahun;
        $params["evidence"] = $request->evidence;

        $total = $this->getTotalDatatable($params);
        $data = $this->generateDataDatatable($params);
        return $dtbHelper->getResult($data, $total);
    }

    public function getTotalDatatable(array $params){
        $query = Secretariat::select("*")
            ->where('periode_bulan',$params["periode_bulan"])
            ->where('periode_tahun',$params["periode_tahun"]);
        if($params["evidence"]){
            $query->whereHas('indikator_sectors', function ($q) use($params){
                if($params["evidence"] == 0)
                    $q->where('evidence', 0);
                else
                    $q->where('evidence', 1);
                return $q;
            });
        }
        if(count($params['searchByColumn']) >0){
            $query->where(function($q) use($params){
                foreach ($params['searchByColumn'] as $column) {
                    if($column == "sector"){
                        $q->orWhereHas('sector', function ($q_sector) use($params){
                            return $q_sector->where('nama','like','%' . $params['searchQuery'] . '%');
                        });
                    }else $q->orWhere($column, 'like', '%' . $params['searchQuery'] . '%');
                }
                return $q;
            });
        }
        return $query->count();
    }

    public function generateDataDatatable(array $params){
        $resultData = $this->getDataDatatable($params);
        $dataTable = array();
        $no = $params['start']+1;
        foreach ($resultData as $row){
            $action = "";
            $url_view = '<a href="'.url($this->base_url."/".$row->id).'" class="btn btn-sm btn-flat btn-success mr-1 ml-1">'.__('form.button.view.icon').'</a>';
            $url_edit = '<a href="'.url($this->base_url."/".$row->id.'/edit').'" class="btn btn-sm btn-flat btn-warning mr-1 ml-1">'.__('form.button.edit.icon').'</a>';
            $url_delete = '<a href="'.url($this->base_url."/".$row->id).'" class="btn-link-delete btn btn-sm btn-flat btn-danger mr-1 ml-1">'.__('form.button.delete.icon').'</a>';

            $action .= $url_view;
            $action .= $url_edit;
            $action .= $url_delete;

            $sector = "";
            if($row->sector_id)
                $sector = $row->sector->nama;
            $bidang_terkait = "";
            $indikator_sectors = $row->indikator_sectors;
            if($indikator_sectors){
                $bidang_terkait = implode(", ",$indikator_sectors->pluck('sector.nama')->toArray());
            }

            $dataRow = [
                "no"            => $no,
                "periode"       => VariableHelper::getMonthName($row->periode_bulan)." ".$row->periode_tahun."<br>".$sector,
                "indikator"     => strip_tags($row->indikator),
                "sector"        => $bidang_terkait,
                "action"        => $action
            ];
            $no+=1;
            array_push($dataTable, $dataRow);
        }
        return $dataTable;
    }

    public function getDataDatatable(array $params){
        $query = Secretariat::select("*");

        if(count($params['searchByColumn']) >0){
            $query->where(function($q) use($params){
                foreach ($params['searchByColumn'] as $column) {
                    if($column == "sector"){
                        $q->orWhereHas('sector', function ($q_sector) use($params){
                            return $q_sector->where('nama','like','%' . $params['searchQuery'] . '%');
                        });
                    }else $q->orWhere($column, 'like', '%' . $params['searchQuery'] . '%');
                }
                return $q;
            });
        }
        if(count($params['orders']) >0){
            foreach ($params['orders'] as $column)
                $query->orderBy($column[0],$column[1]);
        }
        if($params["evidence"]){
            $query->whereHas('indikator_sectors', function ($q) use($params){
                if($params["evidence"] == 0)
                    $q->where('evidence', 0);
                else
                    $q->where('evidence', 1);
                return $q;
            });
        }
        $query->where('periode_bulan',$params["periode_bulan"])
            ->where('periode_tahun',$params["periode_tahun"])
            ->offset($params['start'])
            ->limit($params['limit']);

        return $query->get();
    }
}