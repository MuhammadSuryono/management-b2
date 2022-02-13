<?php

namespace App\Http\Controllers;

use App\Data_pengecekan;
use App\E_wallet;
use App\Respondent;
use App\Project;
use App\Team;
use App\Mail\KirimEmail;
use App\Status_kepemilikan;
use App\Status_qc;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_respondent = Respondent::count();
        $total_project = Project::count();
        $total_team = Team::count();

        $respondents = Respondent::select('respondents.*', 'projects.batas_waktu_do')->join('projects', 'projects.id', '=', 'respondents.project_id')->whereNotNull('tanggal_update_qc')->where('tanggal_update_qc', '!=', '0000-00-00 00:00:00')->orderBy('tanggal_update_qc')->get();

        $respondents_grouped = Respondent::select('projects.nama', 'projects.id', DB::raw('count(*) as total'))
            ->join('projects', 'projects.id', '=', 'respondents.project_id')
            ->whereNotNull('tanggal_update_qc')->where('tanggal_update_qc', '!=', '0000-00-00 00:00:00')
            ->groupBy('respondents.project_id')->get();

        $data_pengecekan = Data_pengecekan::where('on_notif', 1)->get();
        $data_pengecekan_grouped = Data_pengecekan::select('projects.nama', 'projects.id', DB::raw('count(*) as total'))
            ->join('respondents', 'respondents.id', '=', 'data_pengecekans.respondent_id')
            ->join('projects', 'projects.id', '=', 'respondents.project_id')
            ->groupBy('respondents.project_id')
            ->where('on_notif', 1)
            ->where(function ($query) {
                $query->where('s1', 1)->orWhere('s2', 1)->orWhere('s3', 1)->orWhere('s4', 1)->orWhere('s5', 1)->orWhere('s6', 1)->orWhere('s7', 1)->orWhere('s8', 1)->orWhere('s9', 1)->orWhere('s10', 1)->orWhere('s11', 1)->orWhere('s12', 1);
            })
            ->get();

        $respondents_fail_paid = Respondent::select('respondent_gifts.*', 'respondents.respname', 'respondents.kota_id', 'respondents.project_id', 'respondents.kategori_gift')
            ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            ->where('respondent_gifts.status_pembayaran_id', 4)->get();
        $respondents_fail_paid_grouped =  Respondent::select('projects.nama', 'projects.id', DB::raw('count(*) as total'))
            ->join('projects', 'projects.id', '=', 'respondents.project_id')
            ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            ->where('respondent_gifts.status_pembayaran_id', 4)
            ->groupBy('respondents.project_id')->get();

        $bank = DB::connection('mysql3')->table('bank')->get()->sortBy('nama');
        $e_wallet = E_wallet::get();
        $status_kepemilikan = Status_kepemilikan::get();

        $projects = Project::whereNotNull('nama')->whereDate('tgl_akhir_kontrak', '>=', date("Y-m-d"))->get();

        $status_qcs = Status_qc::get();

        return view('dashboards/dashboard_gentelella', compact('total_respondent', 'respondents_fail_paid', 'total_project', 'total_team', 'respondents', 'data_pengecekan', 'bank', 'e_wallet', 'status_kepemilikan', 'projects', 'status_qcs', 'respondents_fail_paid_grouped', 'data_pengecekan_grouped', 'respondents_grouped'));
    }

    public function kirimemail()
    {
        $emails = ['fmanadeprasetyo@gmail.com', 'fmandeprasetyoo@gmail.com'];
        Mail::to($emails)->send(new KirimEmail('firman', 'halo', $emails));

        return "Email telah dikirim";
    }

    public function seeEmail()
    {
        return view('email');
    }
}
