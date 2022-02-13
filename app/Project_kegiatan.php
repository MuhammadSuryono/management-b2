<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_kegiatan extends Model
{
    protected $fillable = ['project_plan_id','lokasi_id','tanggal','jam','tema','absen_tutup'];
    public function project_plan() {return $this->belongsTo('App\Project_plan');}
    public function lokasi() {return $this->belongsTo('App\Lokasi');}
    public function project_absensi() {return $this->hasMany('App\Project_absensi');}
}
