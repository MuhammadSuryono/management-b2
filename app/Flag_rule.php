<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flag_rule extends Model
{
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
