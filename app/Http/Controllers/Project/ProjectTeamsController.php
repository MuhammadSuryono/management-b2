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
        $project_jabatan = Project_jabatan::firstWhere('id', $project_jabatan_id);
        $teams = Team::all()->sortBy('team');
        $add_url = url('/project_teams/create/' . $project_jabatan_id);
        return view('projects.project_teams.index', compact('project_teams', 'project_jabatan', 'add_url'));
    }

    public function add_team(Project_jabatan $project_jabatan)
    {
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create($project_jabatan_id)
    {
        $project_jabatan = Project_jabatan::firstWhere('id', $project_jabatan_id);
        $teams = DB::select('select teams.* from teams join team_jabatans on teams.id = team_jabatans.team_id where jabatan_id=?
        and team_id not in (select team_id from project_teams where project_jabatan_id=?)', [$project_jabatan->jabatan_id, $project_jabatan_id]);

        if ($project_jabatan->jabatan->jabatan != "Team Leader (TL)") {
            $teamLeaders = Project_jabatan::with(['project_team' => function($q) {
                $q->with(['team' => function($query) {
                    $query->select('id', 'nama');
                }])->get();
            }])->where('project_kota_id', $project_jabatan->project_kota_id)->where('jabatan_id', '9')->first();
            return view('projects.project_teams.add_team_list', compact('teams', 'project_jabatan', 'teamLeaders'));
        }
        return view('projects.project_teams.add_team_list', compact('teams', 'project_jabatan'));
    }

    public function create_old($project_jabatan_id)
    {
        $project_jabatan = Project_jabatan::firstWhere('id', $project_jabatan_id);
        $kota_id = $project_jabatan->project_kota->kota_id;
        $project_team_id = Project_team::where('project_jabatan_id', $project_jabatan_id)
            ->select('team_id')->get()->toArray();
        $teams = DB::select('SELECT id, nama FROM teams
            where kota_id = ' . $project_jabatan->project_kota->kota_id . '
            and id in
                (select team_id
                    from team_jabatans
                    where jabatan_id= ' . $project_jabatan->jabatan_id  .
            ')
            and id not in
            (select team_id from project_teams where project_teams.project_jabatan_id = '
            . $project_jabatan_id . ');  ');

        $project_team = Project_team::first();
        return view('projects.project_teams.create', compact('project_team', 'project_jabatan', 'teams'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if (count($request->available_team_id) > 0) {
            $i = 0;
            foreach ($request->available_team_id as $new_team_id) {
                Project_team::create([
                    'project_jabatan_id' => $request->project_jabatan_id,
                    'team_id' => $new_team_id,
                    'gaji' => !is_null($request->honor[$i]) ? $request->honor[$i] : 0,
                    'user_id' => session('user_id'),
                    'type_tl' => $request->jenis_tl[$i],
                    'team_leader' => (int)$request->leader
                ]);
                $i++;
            }
        }
        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Saved');
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

    public function delete(Project_team $projectTeam)
    {
        Project_team::destroy($projectTeam->id);
        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Deleted');
    }

    public function member_team_leader($teamLeaderId)
    {
        $member = Project_team::with(['team', 'project_jabatan' => function($q) {
            $q->with(['jabatan']);
        }])->where('team_leader', $teamLeaderId)->get();
        $leaderName = Team::find($teamLeaderId)->nama;
        $member[0]->leader_name = $leaderName;
        return response()->json($member);
    }

    public function update_team_leader(Request $request, $id)
    {
        $project_team = Project_team::find($id);
        $project_team->team_leader = $request->leader;
        $project_team->save();
        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Saved');
    }
}
