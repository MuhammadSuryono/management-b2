<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['user_login', 'nama', 'email', 'level', 'password', 'divisi_id'];
    public function divisi()
    {
        return $this->belongsTo('App\Divisi');
    }
    public function team()
    {
        return $this->hasMany('App\Team');
    }
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
    public function project()
    {
        return $this->hasMany('App\Project');
    }
    public function project_kota()
    {
        return $this->hasMany('App\Project_kota');
    }
    public function user_role()
    {
        return $this->hasMany('App\User_role');
    }
    public function project_absensi()
    {
        return $this->hasMany('App\Project_absensi');
    }
}
