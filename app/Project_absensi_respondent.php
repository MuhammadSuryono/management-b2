<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_absensi_respondent extends Model
{
    protected $fillable = ['project_plan_id', 'respondent_id', 'nomor_rekening', 'kode_bank', 'pemilik_rekening', 'pemilik_rekening', 'evidence', 'created_at', 'updated_at'];
    public function project_plan()
    {
        return $this->belongsTo('App\Project_plan');
    }
    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }
}
