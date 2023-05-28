<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndikatorSector extends Model
{
    //
    protected $table = "indikator_sectors";

    public function sector(){
        return $this->hasOne("App\Sector","id","sector_id");
    }
}
