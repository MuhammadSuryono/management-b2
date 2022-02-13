<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nama_produk extends Model
{
    protected $fillable=['nama_produk','tipe_produk_id', 'updated_by_id'];
    public function tipe_produk() {return $this->belongsTo('App\Tipe_produk');}
    public function updated_by() {return $this->belongsTo('App\User');}
}
