<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_budget_integration_tl extends Model
{
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function jabatan()
    {
        return $this->belongsTo('App\Jabatan');
    }
}
