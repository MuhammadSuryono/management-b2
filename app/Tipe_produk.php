<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipe_produk extends Model
{
    protected $fillable=['tipe_produk','kategori_produk_id','updated_by_id'];
    public function nama_produk() {return $this->hasMany('App\Nama_produk');}
    public function kategori_produk() {return $this->belongsTo('App\Kategori_produk');}
    public function updated_by() {return $this->belongsTo('App\User');}
}
