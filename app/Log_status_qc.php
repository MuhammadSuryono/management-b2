<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_status_qc extends Model
{
    protected $fillable = ['respodent_id', 'status_qc_id', 'created_at'];
    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }
    public function status_qc()
    {
        return $this->belongsTo('App\Status_qc');
    }
}
