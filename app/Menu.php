<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable=['menu','updated_by_id'];
    public function updated_by() {return $this->belongsTo('App\User');}
}
