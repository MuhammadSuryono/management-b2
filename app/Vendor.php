<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;
    protected $fillable = ['nama_perusahaan', 'alamat', 'contact_person', 'no_telp_kantor', 'no_telp_personal', 'email', 'website', 'npwp', 'bukti_npwp'];
    public function vendor_layanan()
    {
        return $this->hasMany('App\Team_bahasa');
    }
    public function proejct()
    {
        return $this->hasMany('App\Project');
    }
}
