<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team_jabatan extends Model
{
    protected $fillable = ['team_id','jabatan_id','jumlah','user_id'];
    public function jabatan() {return $this->belongsTo('App\Jabatan');}
    public function team() {return $this->belongsTo('App\Team');}
}
