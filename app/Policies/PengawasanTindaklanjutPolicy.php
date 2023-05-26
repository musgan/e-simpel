<?php

namespace App\Policies;

use App\Repositories\PengawasanRegulerRepositories;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengawasanTindaklanjutPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function view($user,$sector_category,$sector_alias){
        $roleAllowed = ["admin","kapan","mpn"];
        return $this->isAvaibleTorun($user,$sector_category,$sector_alias, $roleAllowed);
    }
    private function isAvaibleTorun($user,$sector_category,$sector_alias, $roleAllowed){
        $role = strtolower($user->user_level->alias);
        if($role == "admin")
            return true;
        $sectors = $user->user_level_groups->pluck('sector_id')->toArray();
        $cek_role = in_array($role, $roleAllowed);
        if($cek_role === false)
            return false;

        $repo = new PengawasanRegulerRepositories($sector_category,$sector_alias);
        if($repo->isSectorInArray($sectors) === false)
            return false;

        return true;
    }
    public function action($user,$sector_category,$sector_alias){
        $roleAllowed = ["admin","kapan"];
        return $this->isAvaibleTorun($user,$sector_category,$sector_alias, $roleAllowed);
    }
}
