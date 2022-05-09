<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingRoute extends Model
{
    protected $table = 'setting_route';
    protected $fillable = ['id', 'route_name', 'route_path', 'route_status', 'created_at', 'updated_at'];
}
