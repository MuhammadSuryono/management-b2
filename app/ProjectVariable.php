<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectVariable extends Model
{
    protected $table = 'project_variables';

    public function projectKota()
    {
        return $this->belongsTo('App\Project_Kota', 'selection_id', 'id');
    }
}
