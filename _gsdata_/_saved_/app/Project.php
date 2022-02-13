<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable=['nama','kode_project','max_budget','customer_id','project_date', 'date_start_target','date_finish_target','date_start_real','date_finish_real','ket','user_id'];
    public function customer2() {return $this->belongsTo('App\Customer2','customer_id');}
    public function user() {return $this->belongsTo('App\User');}
    public function project_kota() {return $this->hasMany('App\Project_kota');}
    public function project_plan() {return $this->hasMany('App\Project_plan');}
}
