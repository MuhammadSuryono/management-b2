<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran_interviewer extends Model
{
    protected $fillable = ['project_id', 'team_id', 'status_pembayaran_id', 'tanggal_pengajuan', 'tanggal_pembayaran', 'total', 'created_at'];
    public function Team()
    {
        return $this->belongsTo('App\Team');
    }
}
