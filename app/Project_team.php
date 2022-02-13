<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_team extends Model
{
    protected $fillable = ['project_jabatan_id', 'team_id', 'user_id', 'gaji'];
    public function project_jabatan()
    {
        return $this->belongsTo('App\Project_jabatan');
    }
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
    public function project_team()
    {
        return $this->hasMany('App\Project_team');
    }

    // public function scopeFilter($query, $params)
    // {
    //     if (isset($_GET['project_jabatan_id']) && $_GET['project_jabatan_id'] != 'all') {
    //         if (isset($params['project_jabatan_id']) && trim($params['project_jabatan_id']) !== 'all') {
    //             $query->where('project_jabatan_id', '=', trim($params['project_jabatan_id']));
    //         }
    //         if (isset($params['kota_id']) && trim($params['kota_id']) !== 'all') {
    //             $query->where('kota_id', '=', trim($params['kota_id']));
    //         }
    //         return $query;
    //     } else {
    //         $query->where('project_id', '<', '0');
    //     }
    // }
}
