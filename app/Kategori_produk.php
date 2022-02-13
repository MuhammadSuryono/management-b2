<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori_produk extends Model
{
    protected $fillable=['kategori_produk','updated_by_id'];
    // public function respondent() {return $this->hasMany('App\Respondent','projectid','projectid');}

    public function tipe_produk() {return $this->hasMany('App\Tipe_produk');}
    public function updated_by() {return $this->belongsTo('App\User');}
}
