<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable=['jabatan'];
    public function team() {return $this->hasMany('App\Team');}
    public function project_kota() {return $this->hasMany('App\Project_kota');}
}
