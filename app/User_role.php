<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    protected $fillable=['user_id','role_id','created_by','updated_by'];
    public function role() {return $this->belongsTo('App\Role');}
    public function user() {return $this->belongsTo('App\User');}

}
