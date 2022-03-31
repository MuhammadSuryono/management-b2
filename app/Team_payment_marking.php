<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team_payment_marking extends Model
{
    protected $fillable = ['project_id', 'team_id', 'posisi', 'created_at'];
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function projectTeam()
    {
        return $this->belongsTo('App\Project_team', 'project_team_id');
    }
}
