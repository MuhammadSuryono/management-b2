<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_imported extends Model
{
    protected $fillable = ['project_imported'];
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
    public function respondent_gift()
    {
        return $this->hasMany('App\Respondent_gift');
    }
}
