<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project_jabatan;
use App\Project_kota;
use App\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectJabatansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_kota_id)
    {
        $project_jabatans = Project_jabatan::where('project_kota_id', $project_kota_id)->get();
        $jabatans = Jabatan::all()->sortBy('jabatan');
        $project_kota = Project_kota::firstWhere('id', $project_kota_id);
        $add_url = url('/project_jabatans/create/' . $project_kota_id);
        return view('projects.project_jabatans.index', compact('project_jabatans', 'project_kota', 'project', 'add_url'));
    }

    public function create($project_kota_id)
    {
        $project_kota = Project_kota::firstWhere('id', $project_kota_id);
        $jabatans = DB::select('select DISTINCT jabatans.id, jabatan from jabatans left join project_jabatans on jabatans.id = project_jabatans.jabatan_id where jabatans.id not in (select jabatan_id from project_jabatans where project_kota_id= ' . $project_kota_id . ')');
        // dd('tet');
        return view('projects.project_jabatans.add_jabatan_list', compact('jabatans', 'project_kota'));
    }

    public function create_old($project_kota_id)
    {
        $project_kota = Project_kota::firstWhere('id', $project_kota_id);
        $project_jabatan_id = Project_jabatan::where('project_kota_id', $project_kota_id)->select('jabatan_id')->get()->toArray();
        $jabatans = Jabatan::whereNotIn('id', $project_jabatan_id)->get()->sortBy('jabatan');
        $project_jabatan = Project_jabatan::first();
        return view('projects.project_jabatans.create', compact('project_jabatan', 'project_kota', 'jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (count($request->available_jabatan_id) > 0) {
            foreach ($request->available_jabatan_id as $new_jabatan_id) {
                Project_jabatan::create([
                    'project_kota_id' => $request->project_kota_id,
                    'jabatan_id' => $new_jabatan_id,
                    'user_id' => session('user_id'),
                ]);
            }
        }

        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project_jabatan  $projectJabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Project_jabatan $projectJabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project_jabatan  $projectJabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Project_jabatan $project_jabatan)
    {
        $project_kota = Project_kota::firstWhere('id', $project_jabatan->project_kota_id);
        $jabatans = Jabatan::all()->sortBy('jabatan');
        return view('projects.project_jabatans.edit', compact('project_jabatan', 'project_kota', 'jabatans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project_jabatan  $projectJabatan
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Project_jabatan $project_jabatan)
    {
        Project_jabatan::where('id', $project_jabatan->id)->update([
            'project_kota_id' => $request->project_kota_id,
            'jabatan_id' => $request->jabatan_id,
            'user_id' => $request->user_id,
        ]);
        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project_jabatan  $projectJabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project_jabatan $projectJabatan)
    {
        //
    }

    public function delete(Project_jabatan $projectJabatan)
    {
        Project_jabatan::destroy($projectJabatan->id);
        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Deleted');
    }
}
