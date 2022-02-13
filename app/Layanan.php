<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = ['layanan'];
    public function vendor_layanan()
    {
        return $this->hasMany('App\Team_bahasa');
    }
}
