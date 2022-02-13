<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $fillable = ['nama', 'kode_project', 'max_budget', 'customer_id', 'project_date', 'date_start_target', 'date_finish_target', 'date_start_real', 'date_finish_real', 'ket', 'user_id', 'updated_by_id', 'file_timeline', 'file_kuesioner', 'vendor_korporasi', 'batas_waktu_do'];
    public function customer2()
    {
        return $this->belongsTo('App\Customer2', 'customer_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function project_kota()
    {
        return $this->hasMany('App\Project_kota');
    }
    public function project_plan()
    {
        return $this->hasMany('App\Project_plan');
    }
    public function flag_rule()
    {
        return $this->hasMany('App\Flag_rule');
    }
    public function updated_by()
    {
        return $this->belongsTo('App\User');
    }
    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }
    public function vendor()
    {
        return $this->belongsTo('App\Vendor', 'vendor_korporasi');
    }
    public function kategori_fieldwork()
    {
        return $this->belongsTo('App\Kategori_fieldwork');
    }
    public function respondent_gift()
    {
        return $this->hasMany('App\Respondent_gift');
    }
}
