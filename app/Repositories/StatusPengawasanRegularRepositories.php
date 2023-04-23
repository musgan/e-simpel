<?php

namespace App\Repositories;

use App\statusPengawasanRegularModel;

class StatusPengawasanRegularRepositories
{
    public static function getAll(){
        return statusPengawasanRegularModel::orderBy('urutan','ASC')->get();
    }
}