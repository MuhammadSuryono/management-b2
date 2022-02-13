<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Otentikasi extends Model
{
    protected $table = 'users';
    protected $fillable = ['user_login', 'email', 'password', 'level'];
}
