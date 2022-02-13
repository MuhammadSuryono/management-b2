<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable=['task','has_n_id','has_blast_email_id','has_absensi_id','user_id','updated_by_id', 'methodology', 'id_project'];
    public function has_n() {return $this->belongsTo('App\Yes_no','has_n_id','id');}
    public function has_blast_email() {return $this->belongsTo('App\Yes_no','has_blast_email_id','id');}
    public function has_absensi() {return $this->belongsTo('App\Yes_no','has_absensi_id','id');}
    public function project_plan() {return $this->hasMany('App\Project_plan');}
    public function updated_by() {return $this->belongsTo('App\User');}
}
