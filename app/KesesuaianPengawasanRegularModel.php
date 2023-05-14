<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KesesuaianPengawasanRegularModel extends Model
{
    //
    protected $table = "kesesuaian_pengawasan_regular";

    public function item_lingkup_pengawasan(){
        return $this->hasOne("App\ItemLingkupPengawasanModel","id","item_lingkup_pengawasan_id");
    }
}
