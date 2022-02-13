<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SesFinal extends Model
{
    protected $fillable = ['ses_final'];
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
}
