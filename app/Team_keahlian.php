<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team_keahlian extends Model
{
    protected $fillable = ['team_id', 'keahlian_id', 'user_id'];
    public function keahlian()
    {
        return $this->belongsTo('App\Keahlian');
    }
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
