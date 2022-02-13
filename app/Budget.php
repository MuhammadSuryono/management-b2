<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Budget extends Model
{
    //

    protected $connection = 'mysql2';
    protected $table = 'pengajuan';
    protected $primaryKey = 'noid';
    public $timestamps = false;
    protected $guarded = ['noid'];

    public function tes()
    {
        return DB::connection('mysql2')->select('select * from pengajuan', [1]);
    }

    public function getDivisi()
    {
        return DB::connection('mysql2')->table('tb_user')->where('id_user', session('user_login'))->first();
    }

    public function getDataBudgetSelesai($idBudget)
    {
        $nama = DB::connection('mysql2')->table('tb_user')->where('id_user', session('user_login'))->first();
        return DB::connection('mysql2')->table('selesai')
                    ->where('waktu', $idBudget)
                    ->where('pengaju', $nama->nama_user)
                    ->where('divisi', $nama->divisi)
                    ->get();
    }

    public function getAllDataBudgetSelesai($idBudget)
    {
        return DB::connection('mysql2')->table('selesai')
                    ->where('waktu', $idBudget)
                    ->get();
    }

    public function getAllDataBudgetSelesaiDiv($idBudget)
    {
        return DB::connection('mysql2')
                 ->table('selesai')
                 ->select(DB::raw('*, SUM(total) as jumlah'))
                 ->where('waktu', $idBudget)
                 ->groupBy('divisi_budget')
                 ->get();
    }

}
