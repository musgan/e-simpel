<?php

namespace App\Repositories;

use App\Helpers\CostumHelpers;
use App\Helpers\DataTableHelper;
use App\Helpers\VariableHelper;
use App\IndikatorSector;
use App\SettingPeriodHawasbid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndikatorSectorRepositories
{
    private $base_url = "";
    private $sector_category = "";
    private $sector_alias = "";
    private $sector;
    private $has_evidence = '<button class="btn btn-sm btn-flat btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>';
    private $has_not_evicende = '<button class="btn btn-sm btn-flat btn-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>';

    private $kategori = "hawasbid";

    public function __construct($sector_category, $sector_alias)
    {
        $this->sector_category = $sector_category;
        $this->sector_alias = $sector_alias;
        $this->sector = SectorRepositories::getByAliasAndCategory($sector_alias, $sector_category);
    }
    public function setKategori($kategori){
        $this->kategori = $kategori;
    }
    public function getKategori(){
        return $this->kategori;
    }

    public function setBaseUrl($base_url){
        $this->base_url = $base_url;
    }

    public function getSector(){
        return $this->sector;
    }

    public function getDataTable(Request $request){
        $dtbHelper = new DataTableHelper($request);
        $params = $dtbHelper->getParams();
        $params['periode_tahun'] = $request->periode_tahun;
        $params['periode_bulan'] = $request->periode_bulan;
        $params['evidence'] = $request->evidence;
        $total = $this->getTotalDatatable($params);
        $data = $this->generateDataDatatable($params);
        return $dtbHelper->getResult($data, $total);
    }

    public function getQueryDatatable(array $params){
        $query = IndikatorSector::select('indikator_sectors.*')
            ->join('secretariats','secretariats.id','=','secretariat_id')
            ->where("indikator_sectors.sector_id",$this->sector->id)
            ->WhereHas('secretariat', function ($query) use($params){
                $query->where('periode_tahun', $params['periode_tahun'])
                    ->where('periode_bulan', $params['periode_bulan']);
                if($params['evidence'])
                    $query->where('evidence', $params['evidence']);
                return $query;
            });
        $query->where(function ($query) use($params){
            if(count($params['searchByColumn']) >0){
                foreach ($params['searchByColumn'] as $column){
                    $query->orWhere($column,'like','%'.$params['searchQuery'].'%');
                }
            }
        });
        return $query;
    }

    public function getTotalDatatable(array $params){
        $query = $this->getQueryDatatable($params);
        return $query->count();
    }

    public function generateDataDatatable(array $params){
        $resultData = $this->getDataDatatable($params);
        try{
            SettingPeriodeRepositories::isTindakLanjutAvaibleToupdate($this->kategori,
                $params['periode_tahun'],
                $params['periode_bulan']);
            SettingPeriodeRepositories::isHawasbidAvaibleToupdate($this->kategori,
                $params['periode_tahun'],
                $params['periode_bulan']);
        }catch (\Exception $e){
            $hasAction = false;
        }
        $dataTable = array();
        $no = $params['start']+1;
        foreach ($resultData as $row){
            $action = "";
            $url_view = '<a href="'.url($this->base_url."/".$row->id).'" class="btn btn-sm btn-success mr-1 ml-1">'.__('form.button.view.icon').'</a>';
            $url_edit = '<a href="'.url($this->base_url."/".$row->id.'/edit').'" class="btn btn-sm btn-warning mr-1 ml-1">'.__('form.button.edit.icon').'</a>';

                $action .= $url_view;
            if(($this->kategori == "tindak-lanjut" & $hasAction))
                $action .= $url_edit;

            $secretariat = $row->secretariat;
            $periode = ($secretariat)?VariableHelper::getMonthName($secretariat->periode_bulan)." ".$secretariat->periode_tahun: '';

            $dataRow = [
                "no"                => $no,
                "indikator"         => ($secretariat)?$secretariat->indikator: '',
                "periode"           => $periode,
                "uraian"            => $row->uraian,
                "evidence"          => ($row->evidence == 1)?$this->has_evidence:$this->has_not_evicende,
                "created_at"        => CostumHelpers::getDateDMY($row->created_at),
                "action"            => $action
            ];
            $no+=1;
            array_push($dataTable, $dataRow);
        }
        return $dataTable;
    }

    public function getDataDatatable(array $params){
        $query = $this->getQueryDatatable($params);
        if(count($params['orders']) >0){
            foreach ($params['orders'] as $column)
                $query->orderBy($column[0],$column[1]);
        }
        $query->offset($params['start'])
            ->limit($params['limit']);

        return $query->get();
    }

    public function getById($id){
        return IndikatorSector::Where('id', $id)
            ->where('sector_id', $this->sector->id)
            ->first();
    }

    public function upload_evidence($id,Request $request)
    {
        if($request->file('evidence')){
            foreach($request->evidence as $file){
                $fname = $file->getClientOriginalName();
                $pth ="public/evidence/".$this->sector_alias."/".$id."/";
                $fname = CostumHelpers::checkfileName($fname, $pth);

                $file->storeAs($pth,$fname);
            }

            $directory = "public/evidence/".$this->sector_alias."/".$id;
            $files = Storage::allFiles($directory);

            if(count($files) > 0){
                IndikatorSector::where('id',$id)
                    ->where('sector_id', $this->sector->id)
                    ->update([
                        'evidence'  => 1
                    ]);
            }
        }
    }

    public function checkAndDeleteEvidence($id, $evidence_filechecked){
        $dir_evicende = implode("/",["public/evidence","$this->sector_alias",$id]);
        foreach(Storage::allfiles($dir_evicende) as $file){
            if(!in_array($file,$evidence_filechecked))
                Storage::delete($file);
        }
    }

    public function updateUraian($id,Request $request){

        $model = IndikatorSector::where('id',$id)
            ->where('sector_id',$this->sector->id)
            ->first();
        $secretariat = $model->secretariat;
        SettingPeriodeRepositories::isTindakLanjutAvaibleToupdate($this->kategori,
            $secretariat->periode_tahun,
            $secretariat->periode_bulan);
        SettingPeriodeRepositories::isHawasbidAvaibleToupdate($this->kategori,
            $secretariat->periode_tahun,
            $secretariat->periode_bulan);

        $model->uraian = $request->uraian;
        $model->save();
        $this->checkAndDeleteEvidence($id, $request->evidence_filechecked);
        $this->upload_evidence($id,$request);
    }
}