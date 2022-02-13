<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_excel extends Model
{
    protected $fillable = ['excel_file', 'jumlah_record', 'user_id'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
