<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    //
    protected $primaryKey = "key";
    protected $casts = ['key' => 'string'];
}
