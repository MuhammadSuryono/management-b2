<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable=['nama','gender_id','ktp','hp','email','alamat',
    'kota_id','tgl_lahir','pendidikan_id','pekerjaan_id','user_id','tgl_registrasi','updated_by_id'];

    public function gender() {return $this->belongsTo('App\Gender');}
    public function kota() {return $this->belongsTo('App\Kota');}
    public function pendidikan() {return $this->belongsTo('App\Pendidikan');}
    public function pekerjaan() {return $this->belongsTo('App\Pekerjaan');}
    public function team_jabatan() {return $this->hasMany('App\Team_jabatan');}
    public function updated_by() {return $this->belongsTo('App\User');}

    public function getAge(){
        $this->birthdate->diff($this->attributes['tgl_lahir'])
        ->format('%y years, %m months and %d days');
    }
}
