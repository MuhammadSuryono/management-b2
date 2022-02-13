<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tmp_respondent extends Model
{
    public $timestamps = false;
    protected $fillable = ['project', 'intvdate', 'ses_a', 'ses_b', 'finalses', 'respname', 'address', 'cityresp', 'mobilephone', 'email', 'gender', 'usia', 'education', 'occupation', 'sbjnum', 'pewitness', 'srvyr', 'vstart', 'vend', 'pilot', 'rekaman', 'duration', 'upload', 'latitude', 'longitude', 'worksheet', 'kategori_honor', 'kategori_honor_do', 'kategori_gift', 'kode_bank', 'nomor_rekening', 'pemilik_rekening', 'mobilephone_gift', 'e_wallet_code', 'status_kepemilikan_mobilephone', 'nama_pemilik_mobilephone'];
}
