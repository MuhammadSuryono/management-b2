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
        $add_url=url('/project_kegiatans/create/');
        $project_plan=Project_plan::firstWhere('id',session('current_project_plan_id'));
        $project_kegiatans=Project_kegiatan::where('project_plan_id', session('current_project_plan_id'))->orderBy('tanggal', 'ASC')->orderBy('jam','ASC')->get();
        return view('projects.project_kegiatans.index',compact('project_kegiatans','add_url','project_plan'));
    }

    public function create()
    {
        $lokasis=Lokasi::all()->sortBy('lokasi');
        $project_plan=Project_plan::firstWhere('id',session('current_project_plan_id'));
        $project_kegiatan=Project_kegiatan::first()->first();
        return view('projects.project_kegiatans.create', compact('project_kegiatan','project_plan','lokasis'));
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
        ]);
        return redirect('/project_kegiatans/') ->with('status','Saved');
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
        $project_plan=Project_plan::firstWhere('id',session('current_project_plan_id'));
        $lokasis=Lokasi::all()->sortBy('lokasi');
        return view('projects.project_kegiatans.edit', compact('project_kegiatan','project_plan','lokasis'));
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
        Project_kegiatan::where('id',$project_kegiatan->id)->update([
            'project_plan_id' => $request->project_plan_id,
            'lokasi_id' => $request->lokasi_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'absen_tutup' => $request->absen_tutup,
            'tema' => $request->tema,
        ]);
        return redirect('/project_kegiatans/') ->with('status','Updated');
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

    public function delete(Project_kegiatan $project_kegiatan) {
        Project_kegiatan::destroy($projectKegiatan->id);
        return redirect('/project_kegiatans/' . session('current_project_plan_id') ) ->with('status','Deleted');
    }

    public function print_qr(Project_kegiatan $project_kegiatan)
    {
        foreach (glob("files/*.txt") as $filename) {
            unlink($filename);
        }
        foreach (glob("files/*.png") as $filename) {
            unlink($filename);
        }
        return view('projects.project_kegiatans.qr', compact('project_kegiatan'));
    }

}
