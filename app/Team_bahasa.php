<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team_bahasa extends Model
{
    protected $fillable = ['team_id', 'bahasa_id', 'jumlah', 'user_id'];
    public function bahasa()
    {
        return $this->belongsTo('App\Bahasa');
    }
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
