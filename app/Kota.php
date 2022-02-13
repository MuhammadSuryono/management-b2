<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $guarded = ['id'];
    public function customer()
    {
        return $this->hasMany('App\Customer');
    }
    public function team()
    {
        return $this->hasMany('App\Team');
    }
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
    public function respondent_gift()
    {
        return $this->hasMany('App\Respondent_gift');
    }
    public function project_kota()
    {
        return $this->hasMany('App\ProjectKota');
    }
    public function kelurahan()
    {
        return $this->hasMany('App\Kelurahan');
    }
}
