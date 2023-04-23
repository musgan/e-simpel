<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LingkupPengawasanBidangModel extends Model
{
    //
    protected $table = 'lingkup_pengawasan_bidang';

    public function item(){
        return $this->hasOne("App\ItemLingkupPengawasanModel","id","item_lingkup_pengawasan_id");
    }
}
