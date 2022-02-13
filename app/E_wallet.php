<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class E_wallet extends Model
{
    protected $fillable = ['nama', 'kode', 'created_at'];
    public function respondent()
    {
        return $this->hasMany('App\Respondent', 'kode', 'id');
    }
}
