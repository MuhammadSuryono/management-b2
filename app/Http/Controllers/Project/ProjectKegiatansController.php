<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project_kegiatan;
use App\Project_plan;
use App\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectKegiatansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lokasis = Lokasi::all()->sortBy('lokasi');
        $add_url = url('/project_kegiatans/create/');
        $project_plan = DB::table('project_plans')
            ->select('project_plans.*', 'projects.nama', 'db2.*')
            ->join('digitalisasimarketing.project_plan_master as db2', 'db2.id_pp_master', '=', 'project_plans.task_id')
            ->join('projects', 'projects.id', '=', 'project_plans.project_id')
            ->where('project_plans.id', session('current_project_plan_id'))
            ->orderBy('project_plans.urutan', 'asc')
            ->first();
        $project_kegiatan = Project_kegiatan::where('project_plan_id', session('current_project_plan_id'))->orderBy('tanggal', 'ASC')->orderBy('jam', 'ASC')->get();
        // dd($project_kegiatans);
        return view('projects.project_kegiatans.index', compact('project_kegiatan', 'add_url', 'project_plan', 'lokasis'));
    }

    public function create()
    {
        $lokasis = Lokasi::all()->sortBy('lokasi');
        // $project_plan = Project_plan::firstWhere('id', session('current_project_plan_id'));
        $project_plan = DB::table('project_plans')
            ->select('project_plans.*', 'projects.nama', 'db2.*')
            ->join('digitalisasimarketing.project_plan_master as db2', 'db2.id_pp_master', '=', 'project_plans.task_id')
            ->join('projects', 'projects.id', '=', 'project_plans.project_id')
            ->where('project_plans.id', session('current_project_plan_id'))
            ->orderBy('project_plans.urutan', 'asc')
            ->first();
        // $project_kegiatan = Project_kegiatan::first()->first();
        $project_kegiatan = DB::table('project_kegiatans')
            // ->where('project_plan_id', '=', $project_plans->id)
            ->first();
        return view('projects.project_kegiatans.create', compact('project_kegiatan', 'project_plan', 'lokasis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Project_kegiatan::create([
            'project_plan_id' => $request->project_plan_id,
            'lokasi_id' => $request->lokasi_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'absen_tutup' => $request->absen_tutup,
            'tema' => $request->tema,
            'link' => $request->link,
        ]);
        return redirect('/project_kegiatans/')->with('status', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project_kegiatan  $projectKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(Project_kegiatan $projectKegiatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project_kegiatan  $projectKegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Project_kegiatan $project_kegiatan)
    {
        $project_plan = DB::table('project_plans')
            ->select('project_plans.*', 'projects.nama', 'db2.*')
            ->join('digitalisasimarketing.project_plan_master as db2', 'db2.id_pp_master', '=', 'project_plans.task_id')
            ->join('projects', 'projects.id', '=', 'project_plans.project_id')
            ->where('project_plans.id', session('current_project_plan_id'))
            ->orderBy('project_plans.urutan', 'asc')
            ->first();
        $lokasis = Lokasi::all()->sortBy('lokasi');
        return view('projects.project_kegiatans.edit', compact('project_kegiatan', 'project_plan', 'lokasis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project_kegiatan  $projectKegiatan
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Project_kegiatan $project_kegiatan)
    {
        Project_kegiatan::where('id', $project_kegiatan->id)->update([
            'project_plan_id' => $request->project_plan_id,
            'lokasi_id' => $request->lokasi_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'absen_tutup' => $request->absen_tutup,
            'tema' => $request->tema,
            'link' => $request->link,
        ]);
        return redirect('/project_kegiatans/')->with('status', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project_kegiatan  $projectKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project_kegiatan $project_kegiatan)
    {
        //
    }

    public function delete(Project_kegiatan $project_kegiatan)
    {
        Project_kegiatan::destroy($project_kegiatan->id);
        return redirect('/project_kegiatans/')->with('status', 'Deleted');
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
            ->where('project_plans.id', session('current_project_plan_id'))
            ->orderBy('project_plans.urutan', 'asc')
            ->first();

        // $project_kegiatan = Project_kegiatan::where('project_plan_id', $request->id)->orderBy('tanggal', 'ASC')->orderBy('jam', 'ASC')->first();
        $project_kegiatan = DB::table('project_kegiatans')
            ->where('id', '=', $request->project_kegiatan)
            ->orderBy('tanggal', 'ASC')
            ->orderBy('jam', 'ASC')
            ->first();

        // dd($project_kegiatan);
        return view('projects.project_kegiatans.qr', compact('project_kegiatan', 'project_plan'));
    }
}
