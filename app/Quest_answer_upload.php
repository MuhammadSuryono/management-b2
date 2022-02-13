<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quest_answer_upload extends Model
{
    protected $fillable = ['respondent_id', 'answer', 'answer_code', 'created_at', 'updated_at'];
}
