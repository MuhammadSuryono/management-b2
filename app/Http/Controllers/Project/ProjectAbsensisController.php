<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project;
use App\Project_absensi;
use App\Project_kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectAbsensisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $add_url = url('/project_absensis/create/');
        $project_absensis = Project_absensi::all()->sortBy('created_at');
        return view('projects.project_absensis.index', compact('project_absensis', 'add_url'));
    }

    public function list_absen_kegiatan($project_kegiatan_id)
    {

        $project_absensis = Project_absensi::where('project_kegiatan_id', $project_kegiatan_id)->get()->sortBy('created_at');
        $project_plan = DB::table('project_plans')
            ->select('project_plans.*', 'projects.nama', 'db2.*')
            ->join('digitalisasimarketing.project_plan_master as db2', 'db2.id_pp_master', '=', 'project_plans.task_id')
            ->join('projects', 'projects.id', '=', 'project_plans.project_id')
            ->where('project_plans.id', session('current_project_plan_id'))
            ->orderBy('project_plans.urutan', 'asc')
            ->first();
        return view('projects.project_absensis.list_absen_kegiatan', compact('project_absensis', 'project_plan'));
    }

    public function create()
    {
        $project_kegiatans = Project_kegiatan::all();
        $project_absensi = Project_absensi::first()->first();
        return view('projects.project_absensis.create', compact('project_absensi', 'project_kegiatans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project_absensi = Project_absensi::firstOrCreate(
            [
                'project_kegiatan_id' => $request->project_kegiatan_id,
                'user_id' => $request->user_id
            ]
        );
        return redirect('/project_absensis/')->with('status', 'Saved');
    }

    public function scanqr()
    {
        return view('projects.project_absensis.scanqr');
    }

    public function saveqr(Request $request)
    {
        $validatedData = $request->validate([
            'project_kegiatan_id' => 'required|numeric|min:1|max:' . Project_kegiatan::max('id'),
        ]);

        $valid_kegiatan = Project_kegiatan::where('id', $request->project_kegiatan_id)
            ->where('tanggal', date('Y-m-d'))
            ->where('absen_tutup', '>=', date('H:i:s'))->get();

        if (count($valid_kegiatan) > 0) {
            $project_absensi = Project_absensi::firstOrCreate(
                [
                    'project_kegiatan_id' => $request->project_kegiatan_id,
                    'user_id' => session('user_id')
                ]
            );
            return redirect('/project_absensis/')->with('status', 'Saved');
        } else {
            return redirect('/project_absensis/scanqr')->with('status', 'Invalid QR');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Project_absensi  $projectAbsensi
     * @return \Illuminate\Http\Response
     */
    public function show(Project_absensi $projectAbsensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project_absensi  $projectAbsensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Project_absensi $project_absensi)
    {
        $project_kegiatans = Project_kegiatan::all();
        return view('projects.project_absensis.edit', compact('project_absensi', 'project_kegiatans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project_absensi  $projectAbsensi
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Project_absensi $project_absensi)
    {
        Project_absensi::where('id', $project_absensi->id)->update([
            'project_kegiatan_id' => $request->project_kegiatan_id,
            'user_id' => $request->user_id
        ]);
        return redirect('/project_absensis/')->with('status', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project_absensi  $projectAbsensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project_absensi $project_absensi)
    {
        //
    }

    public function delete(Project_absensi $project_absensi)
    {
        Project_absensi::destroy($projectAbsensi->id);
        return redirect('/project_absensis/' . session('current_project_kegiatan_id'))->with('status', 'Deleted');
    }
}
