<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $fillable = ['gender'];
    public function team()
    {
        return $this->hasMany('App\Team');
    }
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
    public function customer_pic()
    {
        return $this->hasMany('App\Customer_pic');
    }
    public function respondent_gift()
    {
        return $this->hasMany('App\Respondent_gift');
    }
}
