<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    protected $fillable=['project_imported_id','intvdate','ses_a_id','ses_b_id','ses_final_id','respname','address',
    'kota_id','mobilephone','email','gender_id','usia','pendidikan_id','pekerjaan_id','is_valid_id','updated_by_id'];
    // Connect to master tables
    public function kota() {return $this->belongsTo('App\Kota');}
    public function gender() {return $this->belongsTo('App\Gender');}
    public function project_imported() {return $this->belongsTo('App\Project_imported');}
    public function ses_a() {return $this->belongsTo('App\SesA');}
    public function ses_b() {return $this->belongsTo('App\SesB');}
    public function ses_final() {return $this->belongsTo('App\SesFinal');}
    public function pendidikan() {return $this->belongsTo('App\Pendidikan');}
    public function pekerjaan() {return $this->belongsTo('App\Pekerjaan');}
    public function is_valid() {return $this->belongsTo('App\Isvalid');}
    public function user() {return $this->belongsTo('App\User');}
    public function updated_by() {return $this->belongsTo('App\User');}

public function scopeFilter($query, $params)
{
    if (isset($_GET['project_imported_id'])) {
        if (isset($params['project_imported_id']) && trim($params['project_imported_id']) !== 'all')
        {  $query->where('project_imported_id', '=', trim($params['project_imported_id']));  }

        if (isset($params['kota_id']) && trim($params['kota_id']) !== 'all')
        {  $query->where('kota_id', '=', trim($params['kota_id']));  }

        if (isset($params['gender_id']) && trim($params['gender_id']) !== 'all')
        {  $query->where('gender_id', '=', trim($params['gender_id']));  }

        if (isset($params['ses_final_id']) && trim($params['ses_final_id']) !== 'all')
        {  $query->where('ses_final_id', '=', trim($params['ses_final_id']));  }

        if (isset($params['pendidikan_id']) && trim($params['pendidikan_id']) !== 'all')
        {  $query->where('pendidikan_id', '=', trim($params['pendidikan_id']));  }

        if (isset($params['pekerjaan_id']) && trim($params['pekerjaan_id']) !== 'all')
        {  $query->where('pekerjaan_id', '=', trim($params['pekerjaan_id']));  }

        if (isset($params['is_valid_id']) && trim($params['is_valid_id']) !== 'all')
        {  $query->where('is_valid_id', '=', trim($params['is_valid_id']));  }
        return $query;
    } else {
        $query->where('pekerjaan_id', '<', '0');
    }
}

}
