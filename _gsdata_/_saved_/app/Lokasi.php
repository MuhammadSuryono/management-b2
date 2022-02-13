<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $fillable=['lokasi'];
    public function project_kegiatan() {return $this->hasMany('App\Project_kegiatan');}

}
