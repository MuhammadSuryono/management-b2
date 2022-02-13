<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data_pengecekan extends Model
{
    protected $fillable = ['respondent_id', 's1', 's2', 's3', 's4', 's5', 's6', 's7', 's8', 's9', 's10', 's11', 's12', 'temuan', 'created_at'];

    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }
    public function status_pengecekan()
    {
        return $this->belongsTo('App\Status_pengecekan');
    }
    public function status_gagal_pengecekan()
    {
        return $this->belongsTo('App\Status_gagal_pengecekan');
    }
}
