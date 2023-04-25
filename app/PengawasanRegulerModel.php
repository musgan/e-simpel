<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengawasanRegulerModel extends Model
{
    //
    protected $table = 'pengawasan_regular';

    public function statuspengawasanregular(){
        return $this->hasOne("App\StatusPengawasanRegularModel","id","status_pengawasan_regular_id");
    }
}
