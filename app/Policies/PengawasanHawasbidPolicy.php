<?php

namespace App\Policies;

use App\Repositories\PengawasanRegulerRepositories;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengawasanHawasbidPolicy extends PengawasanPolicy
{
    public function view($user,$sector_category,$sector_alias){
        $roleAllowed = ["admin","hawasbid","mpn"];
        return $this->isAvaibleTorun($user,$sector_category,$sector_alias, $roleAllowed);
    }

    public function action($user,$sector_category,$sector_alias){
        $roleAllowed = ["admin","hawasbid"];
        return $this->isAvaibleTorun($user,$sector_category,$sector_alias, $roleAllowed);
    }
}
