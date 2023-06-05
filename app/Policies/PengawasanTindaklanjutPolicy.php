<?php

namespace App\Policies;

use App\Repositories\PengawasanRegulerRepositories;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengawasanTindaklanjutPolicy extends PengawasanPolicy
{
    public function view($user,$sector_category,$sector_alias){
        $roleAllowed = ["admin","kapan","mpn"];
        return $this->isAvaibleTorun($user,$sector_category,$sector_alias, $roleAllowed, true);
    }

    public function action($user,$sector_category,$sector_alias){
        $roleAllowed = ["admin","kapan"];
        return $this->isAvaibleTorun($user,$sector_category,$sector_alias, $roleAllowed);
    }
}
