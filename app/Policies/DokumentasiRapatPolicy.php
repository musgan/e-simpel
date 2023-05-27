<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DokumentasiRapatPolicy extends PengawasanPolicy
{
    public function view($user,$sector_category,$sector_alias){
        $roleAllowed = ["admin","hawasbid","kapan","mpn"];
        return $this->isAvaibleTorun($user,$sector_category,$sector_alias, $roleAllowed);
    }

    public function action($user,$sector_category,$sector_alias){
        $roleAllowed = ["admin","hawasbid","kapan"];
        return $this->isAvaibleTorun($user,$sector_category,$sector_alias, $roleAllowed);
    }
}
