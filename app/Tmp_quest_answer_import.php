<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tmp_quest_answer_import extends Model
{
    protected $fillable = ['respondent_id', 'answer', 'answer_code', 'created_at', 'updated_at'];
}
