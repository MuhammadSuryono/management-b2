<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project_schedule extends Model
{
    protected $table = 'project_schedule';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}