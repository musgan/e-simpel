<?php

namespace App\Repositories;

use App\Sector;

class SectorRepositories
{
    public static function getAllSectors(){
        return Sector::select('id','nama','alias','category')
            ->orderBy('category','ASC')
            ->orderBy('id','ASC')->get();
    }
}