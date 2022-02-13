<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Customer;
use App\Project;
use App\Kota;
use App\Project_honor;
use App\Project_honor_do;
use App\Project_honor_gift;
use App\Project_team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectTeamManagementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        // PAK BUDI
        $project_full_teams = DB::select('SELECT pk.kota_id AS id_kota,
            pk.jumlah AS jumlah, pk.id AS project_kota_id, pj.id AS project_jabatan_id, pt.id AS project_team_id, k.kota, j.jabatan, t.nama AS team, xx.nama AS nama_prov, pt.gaji, pt.denda, pt.team_id
        FROM  project_kotas pk
            LEFT JOIN project_jabatans pj ON pk.id = pj.project_kota_id
            LEFT JOIN project_teams pt ON pj.id = pt.project_jabatan_id
            LEFT JOIN kotas k ON pk.kota_id = k.id
            LEFT JOIN jabatans j ON pj.jabatan_id = j.id
            LEFT JOIN teams t ON pt.team_id = t.id
            LEFT JOIN provinsi xx ON pk.id_provinsi = xx.id
        WHERE pk.project_id = ' . $project->id .
            ' ORDER BY kota, jabatan, team;');
        session(['current_project_id' => $project->id]);
        // AKHIR PAK BUDI

        // dd($project);

        // IWAYRIWAY
        $kota = Kota::orderBy('kota', 'asc')->get();
        // AKHIR IWAYRIWA

        $num_rows = [];
        $num_row = 1;
        for ($i = 1; $i < count($project_full_teams); $i++) {
            if ($project_full_teams[$i]->id_kota == $project_full_teams[$i - 1]->id_kota) {
                $num_row++;
            } else {
                array_push($num_rows, $num_row);
                $num_row = 1;
            }
        }
        array_push($num_rows, $num_row);

        // dd($num_rows);

        return view('projects.team_managements.index', compact('project_full_teams', 'project', 'kota', 'num_rows'));
    }

    public function ambilData()
    {
        $provinsi = DB::table('provinsi')
            ->orderBy('nama', 'asc')
            ->get();

        echo json_encode($provinsi);
    }

    public function ambilProvinsi()
    {
        $kota = $_POST['kota'];
        $idProv = explode('-', $kota);

        $provinsi = DB::table('provinsi')
            ->where('id', '=', $idProv[1])
            ->first();

        echo json_encode($provinsi);
    }

    public function tambahHonor(Request $request)
    {
        Project_honor::insert([
            'project_kota_id' => $request->id,
            'nama_honor' => $request->kategori,
            'honor' => $request->honor,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('/project_team_managements/' . $request->project_id)->with('status', 'Data sudah disimpan');
    }

    public function hapusHonor(Request $request)
    {
        // dd(session()->all());current_project_id
        Project_honor::destroy($request->id);

        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Data sudah dihapus');
    }

    public function tambahHonorDo(Request $request)
    {
        Project_honor_do::insert([
            'project_kota_id' => $request->id,
            'nama_honor_do' => $request->kategori,
            'honor_do' => $request->honor,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('/project_team_managements/' . $request->project_id)->with('status', 'Data sudah disimpan');
    }

    public function hapusHonorDo(Request $request)
    {
        // dd(session()->all());current_project_id
        Project_honor_do::destroy($request->id);

        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Data sudah dihapus');
    }

    public function dendaTl(Request $request)
    {
        // dd('here');
        Project_team::where('id', $request->project_team_id)->update([
            'denda' => $request->dendaTl
        ]);

        return redirect('/project_team_managements/' . $request->project_id)->with('status', 'Data sudah disimpan');
    }

    public function tambahHonorGift(Request $request)
    {
        Project_honor_gift::insert([
            'project_kota_id' => $request->id,
            'nama_honor_gift' => $request->kategori,
            'honor_gift' => $request->honor,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('/project_team_managements/' . $request->project_id)->with('status', 'Data sudah disimpan');
    }

    public function hapusHonorGift(Request $request)
    {
        // dd(session()->all());current_project_id
        Project_honor_gift::destroy($request->id);

        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Data sudah dihapus');
    }
}
