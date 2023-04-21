<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LingkupPengawasanModel extends Model
{
    //
    protected $table = 'lingkup_pengawasan';

    public function items()
    {
        return $this->hasMany('App\ItemLingkupPengawasanModel',"lingkup_pengawasan_id","id");
    }
}
