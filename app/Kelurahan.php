<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
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
    public function kota()
    {
        return $this->belongsTo('App\Kota');
    }
    public function respondent_gift()
    {
        return $this->hasMany('App\Respondent_gift');
    }
}
