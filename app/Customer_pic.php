<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_pic extends Model
{
    protected $fillable=['sebutan','nama','gender_id','customer_id','hp','email', 'user_id'];
    public function customer() {return $this->belongsTo('App\Customer');}
    public function gender() {return $this->belongsTo('App\Gender');}
}
