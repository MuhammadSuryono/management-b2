<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respondent_btf extends Model
{
    protected $fillable = ['respondent_id', 'created_by'];
    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }
}
