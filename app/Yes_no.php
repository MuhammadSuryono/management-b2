<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yes_no extends Model
{
    public function task_has_n() {return $this->hasMany('App\Task','id','has_n_id');}
    public function task_has_blast_email() {return $this->hasMany('App\Task','id','has_blast_email_id');}
    public function task_has_absensi() {return $this->hasMany('App\Task','id','has_absensi_id');}
}
