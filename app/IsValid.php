<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IsValid extends Model
{
    protected $fillable = ['is_valid'];
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
}
