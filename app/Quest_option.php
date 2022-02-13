<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quest_option extends Model
{
    protected $fillable = ['quest_question_id', 'option', 'value', 'created_at', 'updated_at'];
}
