<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $fillable=['pekerjaan'];
    public function team() {return $this->hasMany('App\Team');}
    public function respondent() {return $this->hasMany('App\Respondent');}
}
