<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_absensi extends Model
{
    protected $fillable = ['project_plan_id', 'respondent_id', 'team_id', 'user_id'];
    public function project_plan()
    {
        return $this->belongsTo('App\Project_plan');
    }
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
