<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quest_answer extends Model
{
    protected $fillable = ['respondent_id', 'quest_question_id', 'answer', 'answer_code', 'created_at', 'updated_at'];
}
