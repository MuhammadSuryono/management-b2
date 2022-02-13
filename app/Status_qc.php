<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status_qc extends Model
{
    protected $fillable = ['keterangan_qc'];
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
}
