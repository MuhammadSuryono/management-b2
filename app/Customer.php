<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable=['nama','alamat','kota_id','user_id'];
    public function kota() {return $this->belongsTo('App\Kota');}
    public function customer_pic() {return $this->hasMany('App\Customer_pic');}
    public function project() {return $this->hasMany('App\Project');}
}
