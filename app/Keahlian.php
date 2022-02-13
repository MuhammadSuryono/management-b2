<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keahlian extends Model
{
    protected $fillable = ['keahlian'];
    public function team_keahlian()
    {
        return $this->hasMany('App\Team_keahlian');
    }
}
