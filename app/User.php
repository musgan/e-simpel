<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_level(){
        return $this->hasOne("App\UserLevel","id",'user_level_id');
    }
    public function user_level_groups(){
        return $this->hasMany("App\UserLevelGroup","user_id","id");
    }

    protected $table = 'users';
}
