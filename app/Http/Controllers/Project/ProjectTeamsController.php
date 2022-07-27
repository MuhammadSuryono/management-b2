<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project_kota;
use App\Project_team;
use App\Project_jabatan;
use App\Team_jabatan;
use App\Team;
use App\Customer;
use App\Jabatan;
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

        $projectJabatanKota = Project_jabatan::where('project_kota_id', $project_jabatan->project_kota_id)->get();
        $haveLeader = false;
        foreach ($projectJabatanKota as $prj) {
            if ($prj->jabatan_id == 9) {
                $haveLeader = true;
                break;
            }
        }
        $showTeam = true;
        $showColumnHonor = true;
        $showColumnTypeTl = true;
        $typeTl = app('request')->input('type_tl');
        $leader = app('request')->input('leader');
        $team = app('request')->input('team');
        if ($typeTl != null && $typeTl == 'borongan') {
            $showColumnHonor = false;
        }

        if (!$haveLeader) $showColumnTypeTl = false;

        if ($typeTl != null && $team == "Interviewer") $showColumnHonor = false;

        $teams = DB::select('select teams.* from teams join team_jabatans on teams.id = team_jabatans.team_id where jabatan_id=?
        and team_id not in (select team_id from project_teams where project_jabatan_id=?)', [$project_jabatan->jabatan_id, $project_jabatan_id]);

        if ($project_jabatan->jabatan->jabatan != "Team Leader (TL)" && $haveLeader) {
            if ($leader == null) {
                $showTeam = false;
            }
            $teamLeaders = Project_jabatan::with(['project_team' => function($q) {
                $q->with(['team' => function($query) {
                    $query->select('id', 'nama');
                }])->get();
            }])->where('project_kota_id', $project_jabatan->project_kota_id)->where('jabatan_id', '9')->first();
//            dd(json_encode($teams));
            return view('projects.project_teams.add_team_list', compact('showTeam', 'haveLeader', 'showColumnTypeTl', 'project_jabatan', 'teamLeaders', 'teams', 'showColumnHonor'));
        }
        $teamLeaders = [];
        return view('projects.project_teams.add_team_list', compact('showTeam', 'haveLeader', 'showColumnTypeTl', 'teams', 'project_jabatan', 'showColumnHonor','teamLeaders'));
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
        if ($request->available_team_id == null) {
            return redirect()->back()->with('status-fail', 'Team tidak ditemukan');
        }

        if (count($request->available_team_id) > 0) {
            $i = 0;
            foreach ($request->available_team_id as $new_team_id) {
                if (isset($request->jenis_tl[$i])) {
                    if ($request->jenis_tl[$i] == "" || $request->jenis_tl[$i] == null){
                        continue;
                    }
                }
                $target = isset($request->target[$i]) ? $request->target[$i] : 0;
                $honor = isset($request->honor[$i]) ? $request->honor[$i] : 0;
                $typeTl = isset($request->jenis_tl[$i]) ? $request->jenis_tl[$i] : "";
                $team = Team::find($new_team_id);
                Project_team::create([
                    'project_jabatan_id' => $request->project_jabatan_id,
                    'project_kota_id' => $request->projectKotaId,
                    'team_id' => $new_team_id,
                    'gaji' => !is_null($honor) ? $honor : 0,
                    'user_id' => session('user_id'),
                    'type_tl' => $typeTl,
                    'target_tl' => $target,
                    'team_leader' => (int)$request->leader,
                    'srvyr' => sprintf("%03d%04d", $team->kota_id, $team->no_team),
                ]);
                $i++;
            }

            $totalTarget = Project_team::where('project_kota_id', $request->projectKotaId)->sum('target_tl');
            $projectKota = Project_kota::find($request->projectKotaId);
            $projectKota->jumlah = $totalTarget;
            $projectKota->save();
        }
        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Saved');
    }

    public function delete(Project_team $projectTeam)
    {
        $projectTeamData = Project_team::find($projectTeam->id);
        if ($projectTeam->team_leader == 0) {
            Project_team::where("id", $projectTeam->id)->delete();
            Project_team::Where("team_leader", $projectTeamData->team_id)->where("project_kota_id", $projectTeamData->project_kota_id)->delete();

            $projectKota = Project_kota::find($projectTeamData->project_kota_id);
            $projectKota->jumlah = $projectKota->jumlah - $projectTeamData->target_tl;
            $projectKota->save();
        } else {
            Project_team::where("id", $projectTeam->id)->delete();
        }
        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Deleted');
    }

    public function member_team_leader($kotaId, $teamLeaderId)
    {
        $member = Project_team::with(['team', 'project_jabatan' => function($q) {
            $q->with(['jabatan']);
        }])
            ->leftJoin("project_jabatans", "project_teams.project_jabatan_id", "=", "project_jabatans.id")
            ->where("project_jabatans.project_kota_id", $kotaId)
            ->where('team_leader', $teamLeaderId)->get();
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

    public function get_teams(Request $request, $projectJabatanId)
    {
        $project_jabatan = Project_jabatan::firstWhere('id', $projectJabatanId);
        $teams = DB::select('select teams.* from teams join team_jabatans on teams.id = team_jabatans.team_id where jabatan_id=?
        and team_id not in (select team_id from project_teams where project_jabatan_id=?)', [$project_jabatan->jabatan_id, $projectJabatanId]);

        return response()->json($teams);
    }

    public function update_leader(Request $request)
    {
        $project_team = Project_team::find($request->project_team_id);
        $project_team->gaji = $request->honor_tl;
        $project_team->target_tl = $request->target;
        $project_team->type_tl = $request->type_tl;
        $project_team->save();

        $totalTarget = Project_team::where('project_kota_id', $project_team->project_kota_id)->sum('target_tl');
        $projectKota = Project_kota::find($project_team->project_kota_id);
        $projectKota->jumlah = $totalTarget;
        $projectKota->save();
        return redirect('/project_team_managements/' . session('current_project_id'))->with('status', 'Saved');
    }
}
