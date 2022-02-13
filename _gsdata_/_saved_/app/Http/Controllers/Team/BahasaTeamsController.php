<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Team_bahasa;
use App\Team;
use App\Bahasa;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahasaTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bahasa_id)
    {
        $bahasa = Bahasa::firstWhere('id', $bahasa_id);
        $bahasa_teams = Team_bahasa::where('bahasa_id', $bahasa_id)->get();
        $add_url=url('/bahasa_teams/create/'.$bahasa_id);
        return view('teams.bahasa_teams.index', compact('bahasa_teams','bahasa','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($bahasa_id)
    {
        $bahasa = Bahasa::firstWhere('id',$bahasa_id);
        $teams = DB::select('SELECT distinct teams.id, teams.nama FROM teams 
        left join team_bahasas on teams.id = team_bahasas.team_id
        where teams.id not in
            (select team_id from team_bahasas where team_bahasas.bahasa_id = ?)', [$bahasa_id] );
        $bahasa_team=Team_bahasa::limit(1)->get();
        return view('teams.bahasa_teams.create', compact('bahasa_team', 'teams','bahasa'));
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
        Team_bahasa::create([
            'bahasa_id' => $request->bahasa_id,
            'team_id' => $request->team_id,
        ]);
        return redirect('/bahasa_teams/' . $request->bahasa_id ) ->with('status','Saved');
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
    public function edit(Team_bahasa $bahasa_team)
    {
        $bahasa = Bahasa::firstWhere('id', $bahasa_team->bahasa_id);
        $teams = Team::all()->sortBy('nama');
        return view('teams.bahasa_teams.edit', compact('bahasa_team', 'teams','bahasa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team_bahasa $bahasa_team)
    {
        Team_bahasa::where('id',$bahasa_team->id)->update([
            'bahasa_id' => $request->bahasa_id,
            'team_id' => $request->team_id,
        ]);
        return redirect('/bahasa_teams/' . $request->bahasa_id ) ->with('status','Saved');
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

    public function delete(Team_bahasa $teamBahasa) {
        Team_bahasa::destroy($teamBahasa->id);
        return redirect('/bahasa_teams/' . $teamBahasa->bahasa_id ) ->with('status','Deleted');
    }
}
