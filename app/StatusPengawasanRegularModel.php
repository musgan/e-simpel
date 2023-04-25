<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusPengawasanRegularModel extends Model
{
    //
    protected $table = 'status_pengawasan_regular';
    protected $casts = ['id' => 'string'];
}
