<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quest_question extends Model
{
    protected $fillable = ['id_quest_code', 'pertanyaan', 'jenis', 'created_at', 'updated_at'];
}
