<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $fillable = ['nama_divisi', 'email', 'created_at'];
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
