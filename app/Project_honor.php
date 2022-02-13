<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_honor extends Model
{
    protected $fillable = ['project_kota_id', 'nama_honor', 'honor', 'created_at', 'updated_at'];
    public function project_kota()
    {
        return $this->belongsTo('App\Project_kota');
    }
}
