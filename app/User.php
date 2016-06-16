<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
{
	protected $fillable = [
        'name', 'email', 'password',
    ];

	protected $hidden = [
        'password', 'remember_token',
    ];

    public function dailyStats() {
        return $this->hasMany('App\DailyStat');
    }
    
    public function totalStats() {
        return $this->hasOne('App\DailyStat')
            ->summary();
    }

    public function comments() {
        return $this->hasMany('App\Comment')
            ->allComments();
    }
}