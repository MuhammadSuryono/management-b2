<?php

namespace App\Http\Controllers\Project;
use App\Http\Controllers\Controller;
use App\Task;
use App\Project;
use App\Project_plan;
use App\Project_kegiatan;
use App\Project_schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProjectPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $add_url=url('/project_plans/create/');
        $project_plans=Project_plan::where('project_id',session('current_project_id'))->get()->sortBy('urutan');
        return view('projects.project_plans.index',compact('project_plans','add_url'));
    }

    public function create()
    {
        $tasks = Task::all()->sortBy('task');
        $project_plan=Project_plan::limit(1)->get()->first();
        return view('projects.project_plans.create', compact('project_plan','tasks'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $validatedData = $request->validate([
            'urutan' => 'required',
            'task_id' => 'required',
            'ket' => 'required',
        ]);
        Project_plan::create($request->except(['_method','_token']));
        return redirect('/project_plans')->with('status','Data sudah disimpan') ;
    }

    public function show(Project_plan $project_plan)
    {
        //
    }

    public function edit(Project_plan $project_plan)
    {
        $tasks = Task::all()->sortBy('task');
        return view('projects.project_plans.edit', compact('project_plan','tasks'));
    }

    public function update(Request $request, Project_plan $project_plan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $validatedData = $request->validate([
            'urutan' => 'required',
            'task_id' => 'required',
            'ket' => 'required',
        ]);
        Project_plan::where('id', $project_plan->id)->update([
            'project_id'=>$request->project_id,
            'user_id'=>$request->user_id,
            'urutan'=>$request->urutan,
            'task_id'=>$request->task_id,
            'n_target'=>$request->n_target,
            'date_start_target'=>$request->date_start_target,
            'date_finish_target'=>$request->date_finish_target,
            'ket'=>$request->ket,
            
        ]);
        return redirect('/project_plans')->with('status','Data sudah disimpan') ;
    }

    public function delete($id) {
        Project_plan::destroy($id);
        return redirect('/project_plans')->with('status','Data sudah dihapus') ;
    }


    public function prepare_absensi(Project_plan $project_plan)
    {
        session([
            'current_project_plan_id'=>$project_plan->id
        ]);
        return redirect('/project_kegiatans');
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
                            ['nama',$request->nama],
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
        Task::find($request->nama)->update(['methodology' => $request->methodology, 'id_project'=>$request->id_project]);

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
}
