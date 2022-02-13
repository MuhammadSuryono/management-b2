<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project_team;
use App\Project_jabatan;
use App\Team_jabatan;
use App\Team;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_jabatan_id)
    {
        $project_teams = Project_team::where('project_jabatan_id', $project_jabatan_id)->get();
        $project_jabatan= Project_jabatan::firstWhere('id',$project_jabatan_id);
        $teams=Team::all()->sortBy('team');
        $add_url=url('/project_teams/create/'.$project_jabatan_id);
        return view('projects.project_teams.index', compact('project_teams','project_jabatan','add_url'));
    }

    public function add_team(Project_jabatan $project_jabatan)
    {       

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_jabatan_id)
    {
        $project_jabatan = Project_jabatan::firstWhere('id',$project_jabatan_id);
        $teams = DB::select('select teams.* from teams join team_jabatans on teams.id = team_jabatans.team_id where jabatan_id=? and kota_id=?
        and team_id not in (select team_id from project_teams where project_jabatan_id=?)', [$project_jabatan->jabatan_id, $project_jabatan->project_kota->kota_id, $project_jabatan_id] );
        return view('projects.project_teams.add_team_list', compact('teams','project_jabatan'));
    }

    public function create_old($project_jabatan_id)
    {
        $project_jabatan = Project_jabatan::firstWhere('id',$project_jabatan_id);
        $kota_id = $project_jabatan->project_kota->kota_id;
        $project_team_id = Project_team ::where('project_jabatan_id', $project_jabatan_id)
        ->select('team_id')->get()->toArray();
        $teams = DB::select('SELECT id, nama FROM teams 
            where kota_id = '. $project_jabatan->project_kota->kota_id . ' 
            and id in 
                (select team_id 
                    from team_jabatans 
                    where jabatan_id= '. $project_jabatan->jabatan_id  .
                ')
            and id not in 
            (select team_id from project_teams where project_teams.project_jabatan_id = ' 
            . $project_jabatan_id . ');  ');

        $project_team=Project_team::limit(1)->get();
        return view('projects.project_teams.create', compact('project_team', 'project_jabatan','teams'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if (count($request->available_team_id)>0)
        {
            foreach ( $request->available_team_id as $new_team_id)
            {
                Project_team::create([
                    'project_jabatan_id' => $request->project_jabatan_id,
                    'team_id' => $new_team_id,
                    'user_id' => session('user_id'),
                ]);
            }
        }
        return redirect('/project_team_managements/' . session('current_project_id') ) ->with('status','Saved');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Project_team  $projectTeam
     * @return \Illuminate\Http\Response
     */
    public function show(Project_team $projectTeam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project_team  $projectTeam
     * @return \Illuminate\Http\Response
     */
    public function edit(Project_team $project_team)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project_team  $projectTeam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project_team $project_team)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project_team  $projectTeam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project_team $projectTeam)
    {
        //
    }

    public function delete(Project_team $projectTeam) {
        Project_team::destroy($projectTeam->id);
        return redirect('/project_team_managements/' . session('current_project_id') ) ->with('status','Deleted');
    }

}
