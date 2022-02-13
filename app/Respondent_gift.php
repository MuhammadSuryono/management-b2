<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respondent_gift extends Model
{
    protected $fillable = ['respondent_id', 'mobilephone', 'e_wallet_kode', 'status_kepemilikan_id', 'pemilik_mobilephone', 'status_pembayaran_id', 'status_perbaikan_id', 'keterangan_pembayaran', 'pembayaran_via', 'tanggal_update_pembayaran', 'created_by', 'updated_by'];
    public function kota()
    {
        return $this->belongsTo('App\Kota');
    }
    public function kelurahan()
    {
        return $this->belongsTo('App\Kelurahan');
    }
    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }
    public function project_imported()
    {
        return $this->belongsTo('App\Project_imported');
    }
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function status_pembayaran()
    {
        return $this->belongsTo('App\Status_pembayaran');
    }
    public function scopeFilter($query, $params)
    {
        if (isset($_GET['project_imported_id']) && $_GET['project_imported_id'] != 'all') {
            if (isset($params['project_imported_id']) && trim($params['project_imported_id']) !== 'all') {
                $query->where('project_imported_id', '=', trim($params['project_imported_id']));
            }
            if (isset($params['kota_id']) && trim($params['kota_id']) !== 'all') {
                $query->where('kota_id', '=', trim($params['kota_id']));
            }
            if (isset($params['status_pembayaran_id']) && trim($params['status_pembayaran_id']) !== 'all') {
                $query->where('status_pembayaran_id', '=', trim($params['status_pembayaran_id']));
            }
            return $query;
        } else {
            $query->where('project_id', '<', '0');
        }
    }
}
