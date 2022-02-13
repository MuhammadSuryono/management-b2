<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Team_jabatan;
use App\Team;
use App\Jabatan;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JabatanTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($jabatan_id)
    {
        $jabatan = Jabatan::firstWhere('id', $jabatan_id);
        $jabatan_teams = Team_jabatan::where('jabatan_id', $jabatan_id)->get();
        $add_url=url('/jabatan_teams/create/'.$jabatan_id);
        return view('teams.jabatan_teams.index', compact('jabatan_teams','jabatan','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($jabatan_id)
    {
        $jabatan = Jabatan::firstWhere('id',$jabatan_id);
        $teams = DB::select('SELECT distinct teams.id, teams.nama FROM teams 
        left join team_jabatans on teams.id = team_jabatans.team_id
        where teams.id not in
            (select team_id from team_jabatans where team_jabatans.jabatan_id = ?)', [$jabatan_id] );
        $jabatan_team=Team_jabatan::limit(1)->get();
        return view('teams.jabatan_teams.create', compact('jabatan_team', 'teams','jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Team_jabatan::create($request->all());
        Team_jabatan::create([
            'jabatan_id' => $request->jabatan_id,
            'team_id' => $request->team_id,
        ]);
        return redirect('/jabatan_teams/' . $request->jabatan_id ) ->with('status','Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team_jabatan  $teamJabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Team_jabatan $teamJabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team_jabatan  $teamJabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Team_jabatan $jabatan_team)
    {
        $jabatan = Jabatan::firstWhere('id', $jabatan_team->jabatan_id)->get();
        $teams = Team::all()->sortBy('nama');
        return view('teams.jabatan_teams.edit', compact('jabatan_team', 'teams','jabatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team_jabatan  $teamJabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team_jabatan $jabatan_team)
    {
        Team_jabatan::where('id',$jabatan_team->id)->update([
            'jabatan_id' => $request->jabatan_id,
            'team_id' => $request->team_id,
        ]);
        return redirect('/jabatan_teams/' . $request->jabatan_id ) ->with('status','Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team_jabatan  $teamJabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team_jabatan $teamJabatan)
    {
        //
    }

    public function delete(Team_jabatan $teamJabatan) {
        Team_jabatan::destroy($teamJabatan->id);
        return redirect('/jabatan_teams/' . $teamJabatan->jabatan_id ) ->with('status','Deleted');
    }
}
