<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_plan extends Model
{
    protected $fillable = ['user_id', 'urutan', 'project_id', 'task_id', 'date_start_target', 'date_finish_target', 'date_start_real', 'date_finish_real', 'n_target', 'n_real', 'ket', 'kode_project', 'peserta_internal_id', 'peserta_external_id'];
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function task()
    {
        return $this->belongsTo('App\Task');
    }
    public function project_kegiatan()
    {
        return $this->hasMany('App\Project_kegiatan');
    }
}
