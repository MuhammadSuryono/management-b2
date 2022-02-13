<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status_callback extends Model
{
    protected $fillable = ['keterangan_callback'];
    public function respondent()
    {
        return $this->hasMany('App\Respondent');
    }
}
