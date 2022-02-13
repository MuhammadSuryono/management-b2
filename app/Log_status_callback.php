<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_status_callback extends Model
{
    protected $fillable = ['respodent_id', 'status_callback_id', 'created_at'];
    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }
    public function status_callback()
    {
        return $this->belongsTo('App\Status_callback');
    }
}
