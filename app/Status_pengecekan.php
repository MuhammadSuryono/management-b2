<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status_pengecekan extends Model
{
    protected $fillable = ['keterangan_gagal_pengecekan', 'code'];
    public function status_gagal_pengecekan()
    {
        return $this->hasMany('App\Data_pengecekan');
    }
}
