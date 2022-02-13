<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_insert_bpu extends Model
{
    protected $fillable = ['project_id', 'tanggal_pengajuan', 'created_at'];
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
