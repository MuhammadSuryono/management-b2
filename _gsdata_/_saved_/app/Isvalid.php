<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Isvalid extends Model
{
    public function respondent() {return $this->hasMany('App\Respondent');}
    
}
