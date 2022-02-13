<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status_pembayaran extends Model
{
    protected $fillable = ['keterangan_pembayaran'];
    public function respondent_gift()
    {
        return $this->hasMany('App\Respondent_gift');
    }
}
