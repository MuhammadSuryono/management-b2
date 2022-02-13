<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $fillable=['lokasi', 'updated_by_id'];
    public function project_kegiatan() {return $this->hasMany('App\Project_kegiatan');}
    public function updated_by() {return $this->belongsTo('App\User');}

}
