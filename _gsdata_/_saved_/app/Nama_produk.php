<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nama_produk extends Model
{
    protected $fillable=['nama_produk','tipe_produk_id'];
    public function tipe_produk() {return $this->belongsTo('App\Tipe_produk');}
}
