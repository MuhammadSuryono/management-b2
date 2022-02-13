<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Team_bahasa;
use App\Team;
use App\Bahasa;
use App\Customer;
use App\Keahlian;
use App\Team_keahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeahlianTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($keahlian_id)
    {
        $keahlian = Keahlian::firstWhere('id', $keahlian_id);
        $keahlian_teams = Team_keahlian::where('keahlian_id', $keahlian_id)->get();
        $add_url = url('/keahlian_teams/create/' . $keahlian_id);
        return view('teams.keahlian_teams.index', compact('keahlian_teams', 'keahlian', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($keahlian_id)
    {
        $keahlian = Keahlian::firstWhere('id', $keahlian_id);
        $teams = DB::select('SELECT distinct teams.id, teams.nama FROM teams 
        left join team_keahlians on teams.id = team_keahlians.team_id
        where teams.id not in
            (select team_id from keahlians where team_keahlians.keahlian_id = ?)', [$keahlian_id]);
        $keahlian_team = Team_keahlian::first();
        return view('teams.keahlian_teams.create', compact('keahlian_team', 'teams', 'keahlian'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Team_bahasa::create($request->all());
        Team_keahlian::create([
            'keahlian_id' => $request->keahlian_id,
            'team_id' => $request->team_id,
        ]);
        return redirect('/keahlian_teams/' . $request->keahlian_id)->with('status', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function show(Team_bahasa $teamBahasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function edit(Team_keahlian $keahlian_team)
    {
        $keahlian = Keahlian::firstWhere('id', $keahlian_team->keahlian_id);
        $teams = Team::all()->sortBy('nama');
        return view('teams.keahlian_teams.edit', compact('keahlian_team', 'teams', 'keahlian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team_keahlian $keahlian_team)
    {
        Team_keahlian::where('id', $keahlian_team->id)->update([
            'keahlian_id' => $request->keahlian_id,
            'team_id' => $request->team_id,
        ]);
        return redirect('/keahlian_teams/' . $request->keahlian_id)->with('status', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team_bahasa $teamBahasa)
    {
        //
    }

    public function delete(Team_keahlian $teamKeahlian)
    {
        Team_keahlian::destroy($teamKeahlian->id);
        return redirect('/keahlian_teams/' . $teamKeahlian->keahlian_id)->with('status', 'Deleted');
    }
}
