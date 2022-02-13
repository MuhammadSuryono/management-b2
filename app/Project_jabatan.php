<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_jabatan extends Model
{
    protected $fillable = ['project_kota_id','jabatan_id','user_id'];
    public function project_kota() {return $this->belongsTo('App\Project_kota');}
    public function jabatan() {return $this->belongsTo('App\Jabatan');}
    public function project_team() {return $this->hasMany('App\Project_team');}
    
}
