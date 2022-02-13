<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SesA extends Model
{
    protected $fillable = ['ses_a'];
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
}
