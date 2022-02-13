<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $fillable=['pendidikan'];
    public function Team() {return $this->hasMany('App\Team');}
    public function respondent() {return $this->hasMany('App\Respondent');}
}
