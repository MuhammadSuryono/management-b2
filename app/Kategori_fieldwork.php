<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori_fieldwork extends Model
{
    protected $fillable = ['kategori_fieldwork', 'updated_by_id'];
    // public function respondent() {return $this->hasMany('App\Respondent','projectid','projectid');}

    public function project()
    {
        return $this->hasMany('App\Project');
    }
}
