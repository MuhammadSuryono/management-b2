<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SesB extends Model
{
    protected $fillable=['ses_b'];
    public function respondent() {return $this->hasMany('App\Respondent');}
}
