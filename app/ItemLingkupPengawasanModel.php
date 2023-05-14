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
    public function pengawasan_regular(){
        return $this->hasMany('App\PengawasanRegulerModel', "item_lingkup_pengawasan_id",'id');
    }
    public function kesesuaian_pengawasan_regular(){
        return $this->hasMany('App\KesesuaianPengawasanRegularModel', "item_lingkup_pengawasan_id",'id');
    }
    public function lingkup_pengawasan_bidang(){
        $this->hasMany('App\LingkupPengawasanBidangModel', 'item_lingkup_pengawasan_id','id');
    }
}
