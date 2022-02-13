<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bahasa extends Model
{
    protected $fillable = ['bahasa'];
    public function team_bahasa()
    {
        return $this->hasMany('App\Team_bahasa');
    }
}
