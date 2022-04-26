<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NominalDenda extends Model
{
    protected $table = 'nominal_denda';

    public function variable()
    {
        return $this->belongsTo('App\ProjectVariable', 'variable_id');
    }

    public function projectKota()
    {
        return $this->belongsTo('App\Project_Kota', 'selection_id');
    }
}
