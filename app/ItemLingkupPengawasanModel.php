<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemLingkupPengawasanModel extends Model
{
    //
    protected $table = 'item_lingkup_pengawasan';

    public function lingkup_pengawasan(){
        return $this->hasOne("App\LingkupPengawasanModel","id","lingkup_pengawasan_id");
    }
}
