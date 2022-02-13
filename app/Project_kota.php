<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_kota extends Model
{
    protected $guarded = ['id'];
    public function kota()
    {
        return $this->belongsTo('App\Kota');
    }
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function project_jabatan()
    {
        return $this->hasMany('App\Project_jabatan');
    }
}
