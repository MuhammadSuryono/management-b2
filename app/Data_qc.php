<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data_qc extends Model
{
    protected $fillable = ['respondent_id', 'tanggal_qc', 'jam_qc', 'callback', 'screenshoot', 'created_at'];

    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }
}
