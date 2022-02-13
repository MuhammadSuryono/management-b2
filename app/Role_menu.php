<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_menu extends Model
{
    protected $fillable=['role_id','menu_id','created_by','updated_by'];
    public function menu() {return $this->belongsTo('App\Menu');}
    public function role() {return $this->belongsTo('App\Role');}

}
