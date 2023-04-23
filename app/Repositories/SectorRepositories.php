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

    public static function getByAliasAndCategory($alias, $category){
        return Sector::where('alias', $alias)
            ->whereRaw('LOWER(category) = "'.$category.'"' )
            ->first();
    }
}