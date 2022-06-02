<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project_jabatan;
use App\Project_kota;
use App\Project_team;
use App\ProjectPlan;
use App\ProjectPlanMaster;
use App\Task;
use App\Lokasi;
use App\Project;
use App\Project_plan;
use App\Project_kegiatan;
use App\Project_schedule;
use App\Divisi;
use App\E_wallet;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\KirimEmail;
use App\Project_absensi;
use App\Project_absensi_respondent;
use App\Respondent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ProjectPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $add_url = url('/project_plans/create/');
        $project_plans = DB::table('project_plans')->where('project_plans.project_id', session('current_project_id'))
            ->join('digitalisasimarketing.project_plan_master as db2', 'project_plans.task_id', '=', 'db2.id_pp_master')
            ->select(['project_plans.*', 'db2.nama_kegiatan', 'db2.has_presence'])
            ->get();

        if (count($project_plans) == 0 || strpos(json_encode($project_plans), 'Field Work') == false) {
            $projectPlansMaster = ProjectPlanMaster::where('nama_kegiatan', 'Field Work')->first();
            $project = Project::find(session('current_project_id'));
            $data = [
                'project_id' => session('current_project_id'),
                'urutan' => count($project_plans) == 0 ? 0 : count($project_plans) + 1,
                'task_id' => $projectPlansMaster->id_pp_master,
                'date_start_target' => $project->tgl_kickoff,
                'date_finish_target' => $project->tgl_akhir_kontrak,
                'date_start_real' => $project->tgl_kickoff,
                'hour_start_real' => "08:00:00",
                'date_finish_real' => $project->tgl_akhir_kontrak,
                'hour_finish_real' => "17:00:00",
                'user_id' => session('user_id'),
                'ket' => 'Field Work',
            ];

            $projectPlans = new Project_plan();
            $projectPlans->fill($data);
            $isSaved = $projectPlans->save();

            $project_plans = DB::table('project_plans')->where('project_plans.project_id', session('current_project_id'))
                ->join('digitalisasimarketing.project_plan_master as db2', 'project_plans.task_id', '=', 'db2.id_pp_master')
                ->select(['project_plans.*', 'db2.nama_kegiatan', 'db2.has_presence'])
                ->get();
        }
        return view('projects.project_plans.index', compact('project_plans', 'add_url'));
    }

    public function create()
    {
        $template = DB::connection('mysql3')->table('project_plan_master')
            ->select('*')
            ->orderBy('nama_kegiatan', 'asc')
            ->get();

        $divisi = Divisi::all();
        $team = Team::orderBy('nama')->get();
        return view('projects.project_plans.create', compact('template', 'divisi', 'team'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $time = date('Y-m-d H:i:s');
        $validatedData = $request->validate([
            // 'n_target' => 'required',
            // 'urutan' => 'required',
            'task_id' => 'required',
            'ket' => 'required',
            'date_start_target' => 'required',
            'hour_start_target' => 'required',
            'date_finish_target' => 'required',
            'hour_finish_target' => 'required',
            'ket' => 'required',
        ]);

        $taskName = DB::connection('mysql3')->table('project_plan_master')
            ->select('nama_kegiatan')
            ->where('id_pp_master', $request->task_id)
            ->orderBy('nama_kegiatan', 'asc')
            ->first();

        if ($request->peserta_external || $request->peserta_internal) {
            $emails = [];
            if ($request->peserta_external) {
                for ($i = 0; $i < count($request->peserta_external); $i++) {
                    $team = Team::where('id', $request->peserta_external[$i])->first();
                    array_push($emails, $team->email);
                }
            }
            if ($request->peserta_internal) {
                for ($i = 0; $i < count($request->peserta_internal); $i++) {
                    $getUser = User::where('divisi_id', $request->peserta_internal[$i])->get();
                    foreach ($getUser as $gu) {
                        // dd($gu->email);
                        if ($gu->email) {
                            array_push($emails, $gu->email);
                        }
                    }
                    // $divisi = Divisi::where('id', $request->peserta_internal[$i])->first();
                    // array_push($emails, $divisi->email);
                }
            }
            // dd($emails);
            $data = [
                'status' => 'create',
                'task' => $taskName->nama_kegiatan,
                'date_start' => $request->date_start_target,
                'hour_start' => $request->hour_start_target,
                'date_finish' => $request->date_finish_target,
                'hour_finish' => $request->hour_finish_target,
                'ket' => $request->ket
            ];

            Mail::to($emails)->send(new KirimEmail($data));
        }

        $count = DB::table('project_plans')
            ->where('project_id', '=', session('current_project_id'))
            ->count();

        DB::table('project_plans')->insert([
            'project_id' => session('current_project_id'),
            'urutan' => $count,
            'task_id' => $request->task_id,
            // 'date_start_target' => $request->date_start_target,
            // 'date_finish_target' => $request->date_finish_target,
            'peserta_internal_id' => serialize($request->peserta_internal),
            'peserta_external_id' => serialize($request->peserta_external),
            'date_start_real' => $request->date_start_target,
            'hour_start_real' => $request->hour_start_target,
            'date_finish_real' => $request->date_finish_target,
            'hour_finish_real' => $request->hour_finish_target,
            // 'n_target' => $request->id_project,
            // 'n_real' => $request->n_target,
            'ket' => $request->ket,
            'honor_briefing' => $request->honor_briefing,
            'has_respondent_presence' => ($request->presensi_respondent) ? $request->presensi_respondent : 0,
            'user_id' => session('user_id'),
            'created_at' => $time,
            'updated_at' => $time
        ]);
        // Project_plan::create($request->except(['_method', '_token']));
        return redirect('/project_plans')->with('status', 'Data sudah disimpan');
    }

    public function show(Project_plan $project_plan)
    {
        //
    }

    public function edit(Request $request)
    {
        // dd($request->project_plan);
        // $tasks = Task::all()->sortBy('task');

        $project_plans = DB::table('project_plans')
            ->select('*')
            ->join('digitalisasimarketing.project_plan_master as db2', 'db2.id_pp_master', '=', 'project_plans.task_id')
            ->where('project_plans.id', $request->route('project_plan'))
            ->orderBy('project_plans.urutan', 'asc')
            ->first();

        // dd($project_plans);

        $template = DB::connection('mysql3')->table('project_plan_master')
            ->select('*')
            ->orderBy('nama_kegiatan', 'asc')
            ->get();

        $divisi = Divisi::all();
        $team = Team::orderBy('nama')->get();

        return view('projects.project_plans.edit', compact('project_plans', 'template', 'divisi', 'team'));
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $request->validate([
            'task_id' => 'required',
            'ket' => 'required',
            'date_start_target' => 'required',
            'hour_start_target' => 'required',
            'date_finish_target' => 'required',
            'hour_finish_target' => 'required',
            'ket' => 'required',
        ]);

        $taskName = DB::connection('mysql3')->table('project_plan_master')
            ->select('nama_kegiatan')
            ->where('id_pp_master', $request->task_id)
            ->orderBy('nama_kegiatan', 'asc')
            ->first();

        if ($request->peserta_external || $request->peserta_internal) {
            $emails = [];
            if ($request->peserta_external) {
                for ($i = 0; $i < count($request->peserta_external); $i++) {
                    $team = Team::where('id', $request->peserta_external[$i])->first();
                    array_push($emails, $team->email);
                }
            }
            if ($request->peserta_internal) {
                for ($i = 0; $i < count($request->peserta_internal); $i++) {
                    $divisi = Divisi::where('id', $request->peserta_internal[$i])->first();
                    array_push($emails, $divisi->email);
                }
            }
            $data = [
                'status' => 'edit',
                'task' => $taskName->nama_kegiatan,
                'date_start' => $request->date_start_target,
                'hour_start' => $request->hour_start_target,
                'date_finish' => $request->date_finish_target,
                'hour_finish' => $request->hour_finish_target,
                'ket' => $request->ket,
            ];

            Mail::to($emails)->send(new KirimEmail($data));
        }

        $update = DB::table('project_plans')
            ->where('id', $request->detail_pp)
            ->update([
                'task_id' => $request->task_id,
                'ket' => $request->ket,
                'peserta_internal_id' => serialize($request->peserta_internal),
                'peserta_external_id' => serialize($request->peserta_external),
                'date_start_real' => $request->date_start_target,
                'hour_start_real' => $request->hour_start_target,
                'date_finish_real' => $request->date_finish_target,
                'hour_finish_real' => $request->hour_finish_target,
                'honor_briefing' => $request->honor_briefing,
                'has_respondent_presence' => ($request->presensi_respondent) ? $request->presensi_respondent : 0
            ]);

        // Project_plan::where('id', $project_plan->id)->update([
        //     'project_id' => $request->project_id,
        //     'user_id' => $request->user_id,
        //     'urutan' => $request->urutan,
        //     'task_id' => $request->task_id,
        //     'n_target' => $request->n_target,
        //     'date_start_target' => $request->date_start_target,
        //     'date_finish_target' => $request->date_finish_target,
        //     'ket' => $request->ket,

        // ]);

        return redirect('/project_plans')->with('status', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $projectPlan = Project_plan::where('id', $id)->first();

        $taskName = DB::connection('mysql3')->table('project_plan_master')
            ->select('nama_kegiatan')
            ->where('id_pp_master', $projectPlan->task_id)
            ->orderBy('nama_kegiatan', 'asc')
            ->first();

        if ($projectPlan->peserta_external_id || $projectPlan->peserta_internal_id) {
            $emails = [];
            if (@unserialize($projectPlan->peserta_external_id)) {
                $arrPesertaExternal = unserialize($projectPlan->peserta_external_id);
                for ($i = 0; $i < count($arrPesertaExternal); $i++) {
                    $team = Team::where('id', $arrPesertaExternal[$i])->first();
                    array_push($emails, $team->email);
                }
            }
            if (@unserialize($projectPlan->peserta_internal_id)) {
                $arrPesertaInternal = unserialize($projectPlan->peserta_internal_id);
                for ($i = 0; $i < count($arrPesertaInternal); $i++) {
                    $divisi = Divisi::where('id', $arrPesertaInternal[$i])->first();
                    array_push($emails, $divisi->email);
                }
            }
            $data = [
                'status' => 'delete',
                'task' => $taskName->nama_kegiatan,
                'date_start' => $projectPlan->date_start_real,
                'hour_start' => $projectPlan->hour_start_real,
                'date_finish' => $projectPlan->date_finish_real,
                'hour_finish' => $projectPlan->hour_finish_real,
                'ket' => $projectPlan->ket,
            ];

            Mail::to($emails)->send(new KirimEmail($data));
        }
        // dd('here');

        Project_plan::destroy($id);

        return redirect('/project_plans')->with('status', 'Data sudah dihapus');
    }


    public function prepare_absensi(Request $request)
    {
        $lokasis = Lokasi::all()->sortBy('lokasi');

        $add_url = url('/project_kegiatans/create/');

        $project_plan = DB::table('project_plans')
            ->select('project_plans.*', 'projects.nama', 'db2.*')
            ->join('digitalisasimarketing.project_plan_master as db2', 'db2.id_pp_master', '=', 'project_plans.task_id')
            ->join('projects', 'projects.id', '=', 'project_plans.project_id')
            ->where('project_plans.id', $request->project_plan)
            ->orderBy('project_plans.urutan', 'asc')
            ->first();

        // dd($project_plans);

        // $project_kegiatans = Project_kegiatan::where('project_plan_id', '=', $project_plans->id)->first();
        $project_kegiatan = DB::table('project_kegiatans')
            ->where('project_plan_id', '=', $project_plan->id)
            ->get();

        session([
            'current_project_plan_id' => $request->project_plan
        ]);
        // dd($project_kegiatans);
        return view('projects.project_kegiatans.index', compact('project_plan', 'project_kegiatan', 'add_url', 'lokasis'));
    }

    public function schedule($id)
    {
        $project = Project::find($id);
        // $schedule = DB::table('schedule')
        //                 ->where('methodology', '=', $project->methodology)
        //                 ->get();

        $schedule = DB::select("SELECT * from schedule where methodology =  '$project->methodology' and (id_project is null or id_project = '$project->id')");

        $i = 1;
        foreach ($schedule as $key => $db) {
            $data = [
                'id_project' => $project->id,
                'kode_project' => $project->kode_project,
                'id_methodology' => $db->id,
            ];

            Project_schedule::firstOrCreate($data, ['urutan' => $i++]);
        }

        $project_schedule = DB::select("select a.*, b.nama as nama_schedule from project_schedule a left join schedule b on a.id_methodology = b.id where a.id_project = '$project->id' and a.kode_project = '$project->kode_project' order by a.tgl_schedule, a.urutan asc");

        return view('projects.project_plans.indexIwayRiway', compact('project_schedule', 'project'));
    }

    public function schedule2($id)
    {
        $project = Project::find($id);
        $schedule = DB::select("SELECT * from tasks where methodology =  '$project->methodology' and (id_project is null or id_project = '$project->id')");

        $newSchedule = DB::select("SELECT * from tasks where methodology is null and id_project is null");

        $i = 1;
        foreach ($schedule as $key => $db) {
            $data = [
                'id_project' => $project->id,
                'kode_project' => $project->kode_project,
                'id_methodology' => $db->id,
                'urutan' => $db->id,
            ];

            Project_schedule::firstOrCreate($data);
        }

        $project_schedule = DB::select("select a.*, b.task as nama_schedule from project_schedule a left join tasks b on a.id_methodology = b.id where a.id_project = '$project->id' and a.kode_project = '$project->kode_project' order by a.tgl_schedule, a.urutan asc");

        return view('projects.project_plans.indexIwayRiway2', compact('project_schedule', 'project', 'newSchedule'));
    }

    public function simpanSchedule(Request $request)
    {
        Project_schedule::where('id', '=', $request->id)
            ->update([
                'partisipan' => $request->partisipan,
                'tgl_schedule' => $request->tgl
            ]);

        return redirect("project_plans/schedule/$request->id_project")->with('sukses', 'Berhasil Di Simpan');
    }

    public function simpanSchedule2(Request $request)
    {
        Project_schedule::where('id', '=', $request->id)
            ->update([
                'partisipan' => $request->partisipan,
                'tgl_schedule' => $request->tgl,
                'tgl_selesai' => $request->tglSelesai
            ]);

        return redirect("project_plans/schedule2/$request->id_project")->with('sukses', 'Berhasil Di Simpan');
    }

    public function tambah(Request $request)
    {
        DB::table('schedule')->insert([
            'nama' => $request->nama,
            'methodology' => $request->methodology,
            'id_project' => $request->id_project,
        ]);

        $schedule = DB::table('schedule')->where([
            ['nama', $request->nama],
            ['methodology', $request->methodology],
            ['id_project', $request->id_project]
        ])->first();

        $data = [
            'id_project' => $request->id_project,
            'kode_project' => $request->kode_project,
            'id_methodology' => $schedule->id,
            'partisipan' => $request->partisipan,
            'tgl_schedule' => $request->tgl_schedule,
            'urutan' => $schedule->id,
        ];
        Project_schedule::create($data);

        return redirect("project_plans/schedule/$request->id_project")->with('sukses', 'Berhasil Di Simpan');
    }

    public function tambah2(Request $request)
    {
        Task::find($request->nama)->update(['methodology' => $request->methodology, 'id_project' => $request->id_project]);

        $data = [
            'id_project' => $request->id_project,
            'kode_project' => $request->kode_project,
            'id_methodology' => $request->nama,
            'partisipan' => $request->partisipan,
            'tgl_schedule' => $request->tgl_schedule,
            'tgl_selesai' => $request->tgl_selesai,
            'urutan' => $request->nama,
        ];
        Project_schedule::create($data);

        return redirect("project_plans/schedule2/$request->id_project")->with('sukses', 'Berhasil Di Simpan');
    }

    public function index2()
    {
        $project = Project::find(session('current_project_id'));
        $schedule = DB::select("SELECT * from tasks where methodology =  '$project->methodology' and (id_project is null or id_project = '$project->id') order by id ASC");

        $i = 1;
        foreach ($schedule as $key => $db) {
            $data = [
                'project_id' => $project->id,
                'urutan' => $i++,
                'task_id' => $db->id,
                'user_id' => session('user_id'),
                'kode_project' => $project->kode_project,
            ];

            Project_plan::firstOrCreate($data);
        }

        $add_url = url('/project_plans/create2/');
        $project_plans = Project_plan::where('project_id', session('current_project_id'))
            ->orderBy('date_start_target', 'ASC')
            ->orderBy('urutan', 'ASC')
            ->get();

        return view('projects.project_plans.indexIwayRiway3', compact('project_plans', 'add_url'));
    }

    public function create2()
    {
        $tasks = DB::select("SELECT * from tasks where methodology is null and id_project is null");
        $project_plan = Project_plan::first()->first();
        return view('projects.project_plans.create2', compact('project_plan', 'tasks'));
    }

    public function store2(Request $request)
    {
        $data = $request->except(['_method', '_token', 'project_id', 'task_id']);

        $project = Project::find($request->project_id);
        $task = Project_plan::where('project_id', $request->project_id)->get();

        $data['kode_project'] = $project->kode_project;
        $data['urutan'] = count($task) + 1;

        Project_plan::firstOrCreate(['project_id' => $request->project_id, 'task_id' => $request->task_id], $data);
        return redirect('/project_plans/index2')->with('status', 'Data sudah disimpan');
    }

    public function delete2($id)
    {
        Project_plan::destroy($id);
        return redirect('/project_plans/index2')->with('status', 'Data sudah dihapus');
    }

    public function edit2(Project_plan $project_plan)
    {
        $tasks = Task::find($project_plan->task_id);
        // dd($tasks->id);
        return view('projects.project_plans.edit2', compact('project_plan', 'tasks'));
    }

    public function update2(Request $request)
    {
        // dd($project_plan);

        date_default_timezone_set('Asia/Jakarta');

        Project_plan::where('project_id', $request->project_id)
            ->where('task_id', $request->task_id)
            ->update([
                'user_id' => $request->user_id,
                'n_target' => $request->n_target,
                'date_start_target' => $request->date_start_target,
                'date_finish_target' => $request->date_finish_target,
                'ket' => $request->ket,
            ]);

        return redirect('/project_plans/index2')->with('status', 'Data sudah disimpan');
    }

    public function addTask(Request $request)
    {
        $insert = DB::connection('mysql3')->table('project_plan_master')
            ->insert([
                'nama_kegiatan' => $request->task,
                'has_presence' => is_null($request->has_presence) ? 0 : 1
            ]);

        if ($insert) {
            return redirect('/project_plans/create')->with('status', 'Data sudah disimpan');
        } else {
            return redirect('/project_plans/create')->with('status-fail', 'Data gagal disimpan');
        }
    }

    public function print_qr(Request $request)
    {
        foreach (glob("files/*.txt") as $filename) {
            unlink($filename);
        }
        foreach (glob("files/*.png") as $filename) {
            unlink($filename);
        }

        $project_plan = DB::table('project_plans')
            ->select('project_plans.*', 'projects.nama', 'db2.*')
            ->join('digitalisasimarketing.project_plan_master as db2', 'db2.id_pp_master', '=', 'project_plans.task_id')
            ->join('projects', 'projects.id', '=', 'project_plans.project_id')
            ->where('project_plans.id', $request->project_plan)
            ->orderBy('project_plans.urutan', 'asc')
            ->first();

        // dd($request->project_plan);

        // $project_kegiatan = Project_kegiatan::where('project_plan_id', $request->id)->orderBy('tanggal', 'ASC')->orderBy('jam', 'ASC')->first();
        $project_kegiatan = DB::table('project_kegiatans')
            ->where('id', '=', $request->project_kegiatan)
            ->orderBy('tanggal', 'ASC')
            ->orderBy('jam', 'ASC')
            ->first();

        // dd($project_kegiatan);

        $is_respondent = 0;
        return view('projects.project_plans.qr', compact('project_kegiatan', 'project_plan', 'is_respondent'));
    }

    public function print_qr_respondent(Request $request)
    {
        foreach (glob("files/*.txt") as $filename) {
            unlink($filename);
        }
        foreach (glob("files/*.png") as $filename) {
            unlink($filename);
        }

        $project_plan = DB::table('project_plans')
            ->select('project_plans.*', 'projects.nama', 'db2.*')
            ->join('digitalisasimarketing.project_plan_master as db2', 'db2.id_pp_master', '=', 'project_plans.task_id')
            ->join('projects', 'projects.id', '=', 'project_plans.project_id')
            ->where('project_plans.id', $request->project_plan)
            ->orderBy('project_plans.urutan', 'asc')
            ->first();

        // dd($request->project_plan);

        // $project_kegiatan = Project_kegiatan::where('project_plan_id', $request->id)->orderBy('tanggal', 'ASC')->orderBy('jam', 'ASC')->first();
        $project_kegiatan = DB::table('project_kegiatans')
            ->where('id', '=', $request->project_kegiatan)
            ->orderBy('tanggal', 'ASC')
            ->orderBy('jam', 'ASC')
            ->first();

        $is_respondent = 1;

        // dd($project_kegiatan);
        return view('projects.project_plans.qr', compact('project_kegiatan', 'project_plan', 'is_respondent'));
    }

    public function fill_presence(Request $request)
    {
        $project_plan = Project_plan::where('id', $request->id)->first();
        $peserta_external = [];

        $projectKotaIds = Project_kota::where("project_id", $project_plan->project_id)->pluck("id")->toArray();
        $projectJabatanIds = Project_jabatan::whereIn("project_kota_id", $projectKotaIds)->pluck("id")->toArray();

        $team = Project_team::select("teams.*")->leftJoin("teams", "teams.id", "=", "project_teams.team_id")
            ->whereIn("project_jabatan_id", $projectJabatanIds)
            ->orderBy("teams.nama")
            ->groupBy("teams.id")
            ->get();
//         $respondents = Respondent::where('project_id', $project_plan->project_id)->get()->sortBy('respname');

        $is_respondent = 0;
        return view('projects.project_plans.fill_presence', compact('team', 'project_plan', 'peserta_external', 'is_respondent'));
    }

    public function fill_presence_respondent(Request $request)
    {
        $team = Team::all()->sortBy('nama');
        $project_plan = Project_plan::where('id', $request->id)->first();
        if (@unserialize($project_plan->peserta_external_id)) {
            $peserta_external = unserialize($project_plan->peserta_external_id);
        } else {
            $peserta_external = [];
        }
        $e_wallet = E_wallet::get();

        $respondents = Respondent::where('project_id', $project_plan->project_id)->get()->sortBy('respname');

        $bank = DB::connection('mysql3')->table('bank')->get()->sortBy('nama');
        $is_respondent = 1;
        return view('projects.project_plans.fill_presence', compact('team', 'project_plan', 'respondents', 'peserta_external', 'bank', 'is_respondent', 'e_wallet'));
    }

    public function store_presence(Request $request)
    {
        // dd($request->is_respondent);
        date_default_timezone_set('Asia/Jakarta');
        $time = date('Y-m-d H:i:s');
        // dd($request->is_respondent);
        $link = "/project_plans/fill_presence_respondent/$request->id";
        if ($request->is_respondent == 1) {

            if ($_FILES["evidence"]["name"]) {
                $extension = pathinfo($_FILES["evidence"]["name"], PATHINFO_EXTENSION);
                $nama_gambar = 'evidence-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extension;
                // $target_file = $_SERVER['DOCUMENT_ROOT'] . 'dev-b2/public/uploads/' . $nama_gambar;
                $target_file = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;

                $filesize = filesize($_FILES["evidence"]["tmp_name"]);
                if ($filesize > 5000000) {
                    return redirect($link)->with('status-fail', 'File yang di upload melebihi 5MB');
                } else {
                    $moved = move_uploaded_file($_FILES["evidence"]["tmp_name"], $target_file);
                }
            }
            $insert = Project_absensi_respondent::insert([
                'project_plan_id' => $request->id,
                'respondent_id' => $request->user,
                'nomor_rekening' => $request->norek,
                'kode_bank' => $request->bank,
                'pemilik_rekening' => $request->pemilik_rekening,
                'evidence' => $nama_gambar,
                'created_at' => $time
            ]);
        } else {
            $absensi = Project_absensi::where('project_plan_id', $request->id)->where('team_id', $request->user)->first();
            if ($absensi) {
                return Redirect::back()->withErrors(['msg' => 'Peserta sudah absen']);
            } else {
                $insert = Project_absensi::insert([
                    'project_plan_id' => $request->id,
                    'team_id' => $request->user,
                    'created_at' => $time
                ]);
            }

        }

        return view('otentikasis.login');
    }

    public function show_presence_audience(Request $request)
    {
        $project_absensi = Project_absensi::where('project_plan_id', $request->project_plan_id)->get();
        // dd($project_absensi);
        $is_respondent = 0;
        return view('projects.project_plans.show_audience', compact('project_absensi', 'is_respondent'));
    }

    public function show_presence_audience_respondent(Request $request)
    {
        $project_absensi = Project_absensi_respondent::where('project_plan_id', $request->project_plan_id)->get();
        // dd($project_absensi);
        $is_respondent = 1;
        return view('projects.project_plans.show_audience', compact('project_absensi', 'is_respondent'));
    }

    public function delete_audience(Request $request)
    {

        $data = Project_absensi::where('id', $request->id)->first();
        $planId = $data->project_plan_id;
        Project_absensi::destroy($request->id);
        return redirect('/project_plans/show_presence_audience/' . $planId)->with('status', 'Data sudah dihapus');
    }

    public function checkHasPresence(Request $request)
    {
        $template = DB::connection('mysql3')->table('project_plan_master')
            ->select('*')
            ->where('id_pp_master', $request->idTask)
            ->first();

        echo json_encode($template);
    }
}
