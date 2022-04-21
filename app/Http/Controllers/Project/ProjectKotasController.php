<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project_kota;
use App\Project;
use App\Kota;
use App\Customer;
use App\NominalDenda;
use App\ProjectVariable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectKotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id)
    {
        $project = Project::firstWhere('id', $project_id);
        $project_kotas = Project_kota::where('project_id', $project_id)->get();
        $add_url=url('/project_kotas/create/'.$project_id);
        return view('projects.project_kotas.index', compact('project_kotas','project','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id)
    {
        $project = Project::firstWhere('id', $project_id);
        $project_kota_id = Project_kota::where('project_id',$project_id)->select('kota_id')->get()->toArray();
        $kotas = Kota::whereNotIn('id',$project_kota_id)->get()->sortBy('kota');
        $project_kota=Project_kota::first();
        return view('projects.project_kotas.create', compact('project_kota', 'project','kotas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // PAK BUDI
        // Project_kota::create($request->all());
        // Project_kota::create([
        //     'project_id' => $request->project_id,
        //     'kota_id' => $request->kota_id,
        //     'jumlah' => $request->jumlah,
        //     'user_id' => $request->user_id,
        // ]);

        // return redirect('/project_team_managements/' . $request->project_id ) ->with('status','Saved');
        // AKHIR PAK BUDI

        // IwayRiway
        $kota = explode('-', $request->kota);

        if($kota[0] == 'lain'){
            $cek = DB::table('kotas')
                        ->where('kota', 'like', '%'.$request->kotaBaru.'%')
                        ->count();

            if($cek <= 0){
                // simpan kota baru
                Kota::firstOrCreate(
                        ['id_provinsi'=>$request->provinsi, 'kota'=>$request->kotaBaru]
                    );
                // akhir

                // simpan tbl project_kota
                $kota = Kota::where('kota', '=', $request->kotaBaru)->first();
                Project_kota::firstOrCreate(
                        ['kode_project'=>$request->kode_project,'project_id'=>$request->project_id,'kota_id'=>$kota->id],
                        ['id_provinsi' => $request->provinsi,'jumlah' => 0,'user_id'=>session('user_id')]
                    );
                // akhir
            }

        } else {
            $projectKota = Project_kota::firstOrCreate(
                        ['kode_project'=>$request->kode_project,'project_id'=>$request->project_id,'kota_id'=>$kota[0]],
                        ['id_provinsi' => $request->provinsi,'jumlah' => 0,'user_id'=>session('user_id')]
                    );

            $variableDefault = ProjectVariable::where('project_id', 0)->where('default', 1)->get();
            foreach ($variableDefault as $variable) {
                $nominalDenda = new NominalDenda();
                $nominalDenda->variable_id = $variable->id;
                $nominalDenda->project_id = $request->project_id;
                $nominalDenda->selection_id = $projectKota->id;
                $nominalDenda->type = 'project_kota';
                $nominalDenda->nominal = '0.02';
                $nominalDenda->from = '[total]';
                $nominalDenda->save();
            }

        }

        return redirect('/project_team_managements/' . $request->project_id ) ->with('status','Saved');
        // AKHIR IWAYRIWAY
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project_kota  $projectKota
     * @return \Illuminate\Http\Response
     */
    public function show(Project_kota $projectKota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project_kota  $projectKota
     * @return \Illuminate\Http\Response
     */
    public function edit(Project_kota $project_kota)
    {
        $project = Project::firstWhere('id', $project_kota->project_id);
        $project_kota_id = Project_kota::where('project_id',$project_kota->project_id)
        ->where('kota_id','<>',$project_kota->kota_id)->select('kota_id')->get()->toArray();
        $kotas = Kota::whereNotIn('id',$project_kota_id)->get()->sortBy('kota');
        return view('projects.project_kotas.edit', compact('project_kota', 'project','kotas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project_kota  $projectKota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project_kota $project_kota)
    {
        Project_kota::where('id',$project_kota->id)->update([
            'project_id' => $request->project_id,
            'kota_id' => $request->kota_id,
            'jumlah' => $request->jumlah,
        ]);
        return redirect('/project_team_managements/' . $request->project_id ) ->with('status','Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project_kota  $projectKota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project_kota $projectKota)
    {
        //
    }

    public function delete(Project_kota $projectKota) {
        Project_kota::destroy($projectKota->id);
        return redirect('/project_team_managements/' . $projectKota->project_id ) ->with('status','Deleted');
    }

    public function editJumlah(Request $request)
    {
        DB::table('project_kotas')
            ->where('project_id', '=', $request->project_id)
            ->where('kode_project', '=', $request->kode_project)
            ->where('kota_id', '=', $request->kota_id)
            ->update(['jumlah' => $request->jumlah]);

        return redirect('/project_team_managements/' . $request->project_id ) ->with('status','Saved');
    }

}
