<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Respondent extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'project_imported_id', 'intvdate', 'ses_a_id', 'ses_b_id', 'ses_final_id', 'respname', 'address',
        'kota_id', 'mobilephone', 'email', 'gender_id', 'usia', 'pendidikan_id', 'pekerjaan_id', 'is_valid_id', 'updated_by_id', 'tanggal_update_qc', 'id_user_qc', 'sbjnum', 'status_qc_id', 'worksheet',
        'kategori_honor', 'kategori_honor_do', 'evidence', 'kategori_gift', 'keterangan_pembayaran', 'kode_bank', 'nomor_rekening', 'pemilik_rekening'
    ];
    // Connect to master tables
    public function kota()
    {
        return $this->belongsTo('App\Kota');
    }
    public function kelurahan()
    {
        return $this->belongsTo('App\Kelurahan');
    }
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }
    public function project_imported()
    {
        return $this->belongsTo('App\Project_imported');
    }
    public function ses_a()
    {
        return $this->belongsTo('App\SesA');
    }
    public function ses_b()
    {
        return $this->belongsTo('App\SesB');
    }
    public function ses_final()
    {
        return $this->belongsTo('App\SesFinal');
    }
    public function pendidikan()
    {
        return $this->belongsTo('App\Pendidikan');
    }
    public function pekerjaan()
    {
        return $this->belongsTo('App\Pekerjaan');
    }
    public function is_valid()
    {
        return $this->belongsTo('App\Isvalid');
    }
    public function status_qc()
    {
        return $this->belongsTo('App\Status_qc');
    }
    public function status_callback()
    {
        return $this->belongsTo('App\Status_callback');
    }
    public function status_temuan_dp()
    {
        return $this->belongsTo('App\Status_temuan_dp');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function updated_by()
    {
        return $this->belongsTo('App\User');
    }
    public function data_qc()
    {
        return $this->hasMany('App\Data_qc');
    }
    public function respondent_btf()
    {
        return $this->hasMany('App\Respondent_btf');
    }
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function quest_code()
    {
        return $this->belongsTo('App\Quest_code');
    }
    public function status_pembayaran()
    {
        return $this->belongsTo('App\Status_pembayaran');
    }
    public function e_wallet()
    {
        return $this->belongsTo('App\E_wallet', 'e_wallets', 'kode');
    }
    public function scopeFilter($query, $params)
    {
        if (isset($_GET['project_imported_id'])) {
            if (isset($params['project_imported_id']) && trim($params['project_imported_id']) !== 'all') {
                $query->where('project_imported_id', '=', trim($params['project_imported_id']));
            }

            if (isset($params['kota_id']) && trim($params['kota_id']) !== 'all') {
                $query->where('kota_id', '=', trim($params['kota_id']));
            }

            if (isset($params['gender_id']) && trim($params['gender_id']) !== 'all') {
                $query->where('gender_id', '=', trim($params['gender_id']));
            }

            if (isset($params['ses_final_id']) && trim($params['ses_final_id']) !== 'all') {
                $query->where('ses_final_id', '=', trim($params['ses_final_id']));
            }

            if (isset($params['pendidikan_id']) && trim($params['pendidikan_id']) !== 'all') {
                $query->where('pendidikan_id', '=', trim($params['pendidikan_id']));
            }

            if (isset($params['pekerjaan_id']) && trim($params['pekerjaan_id']) !== 'all') {
                $query->where('pekerjaan_id', '=', trim($params['pekerjaan_id']));
            }

            if (isset($params['is_valid_id']) && trim($params['is_valid_id']) !== 'all') {
                $query->where('is_valid_id', '=', trim($params['is_valid_id']));
            }
            if (isset($params['segment_worksheet']) && trim($params['segment_worksheet']) !== 'all') {
                $query->where('worksheet', '=', trim($params['segment_worksheet']));
            }
            if (isset($params['interviewer_id']) && trim($params['interviewer_id']) !== 'all') {
                $interviewer = Team::where('id', $params['interviewer_id'])->first();
                $kotaId = str_pad($interviewer['kota_id'], 3, '0', STR_PAD_LEFT);
                $interviewerId = str_pad($interviewer['no_team'], 4, '0', STR_PAD_LEFT);
                $code = $kotaId . $interviewerId;

                $query->where('srvyr', '=', $code);
            }

            // if (isset($params['status_pembayaran_id']) && trim($params['status_pembayaran_id']) !== 'all') {
            //     $query->where('status_pembayaran_id', '=', trim($params['status_pembayaran_id']));
            // }
            return $query;
        } else {
            $query->where('pekerjaan_id', '<', '0');
        }
    }
}
