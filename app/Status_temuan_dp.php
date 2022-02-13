<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status_temuan_dp extends Model
{
    protected $fillable = ['keterangan_temuan_dp'];
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
}
