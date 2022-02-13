<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quest_code extends Model
{
    protected $fillable = ['project_id', 'kode', 'created_at', 'updated_at'];
    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }
}
