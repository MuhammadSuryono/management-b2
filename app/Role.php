<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable=['role','user_id','updated_by_id'];
    public function user_role() {return $this->hasMany('App\User_role');}
    public function updated_by() {return $this->belongsTo('App\User');}
}
