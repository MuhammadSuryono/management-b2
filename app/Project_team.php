<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_team extends Model
{
    protected $fillable = ['project_jabatan_id', 'team_id', 'user_id', 'gaji', 'srvyr', 'type_tl', 'team_leader', 'target_tl', 'project_kota_id'];
    public function project_jabatan()
    {
        return $this->belongsTo('App\Project_jabatan');
    }
    public function team()
    {
        return $this->belongsTo('App\Team', 'team_id');
    }
    public function project_team()
    {
        return $this->hasMany('App\Project_team');
    }

    public function memberTeam()
    {
        return $this->hasMany('App\Team', 'id');
    }

    public function projectTeamMember()
    {
        return $this->hasMany('App\Team', 'id');
    }

    public function projectKota()
    {
        return $this->belongsTo('App\Project_kota', 'project_kota_id');
    }
}
