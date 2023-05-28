<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secretariat extends Model
{
    //
    protected $table = "secretariats";

    public function indikator_sectors(){
        return $this->hasMany('App\IndikatorSector','secretariat_id','id');
    }
    public function sector(){
        return $this->hasOne('App\Sector','id','sector_id');
    }
}
