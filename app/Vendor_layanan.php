<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor_layanan extends Model
{
    protected $fillable = ['vendor_id', 'layanan_id', 'user_id'];
    public function layanan()
    {
        return $this->belongsTo('App\Layanan');
    }
    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }
}
