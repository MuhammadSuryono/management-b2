<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'no_team', 'nama', 'gender_id', 'ktp', 'hp', 'email', 'alamat',
        'kota_id', 'tgl_lahir', 'pendidikan_id', 'pekerjaan_id', 'user_id', 'tgl_registrasi', 'nomor_rekening', 'kode_bank', 'bukti_rekening', 'rate_card', 'updated_by_id'
    ];

    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }
    public function kota()
    {
        return $this->belongsTo('App\Kota', 'kota_id');
    }
    public function pendidikan()
    {
        return $this->belongsTo('App\Pendidikan');
    }
    public function pekerjaan()
    {
        return $this->belongsTo('App\Pekerjaan');
    }
    public function team_jabatan()
    {
        return $this->hasMany('App\Team_jabatan');
    }
    public function updated_by()
    {
        return $this->belongsTo('App\User');
    }

    public function getAge()
    {
        $this->birthdate->diff($this->attributes['tgl_lahir'])
            ->format('%y years, %m months and %d days');
    }
}
