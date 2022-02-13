<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer2 extends Model
{
    protected $connection = 'mysql3';
    protected $table='data_perusahaan';
    protected $primaryKey = 'id_perusahaan';
    // protected $fillable=['nama','alamat','kota_id','user_id'];
    public function project() {return $this->hasMany('App\Project','customer_id','id_perusahaan');}
}
