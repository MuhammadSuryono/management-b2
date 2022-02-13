<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Team_bahasa;
use App\Team;
use App\Bahasa;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamBahasasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($team_id)
    {
        $team = Team::firstWhere('id', $team_id);
        $team_bahasas = Team_bahasa::where('team_id', $team_id)->get();
        $add_url=url('/team_bahasas/create/'.$team_id);
        return view('teams.team_bahasas.index', compact('team_bahasas','team','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($team_id)
    {
        $team = Team::firstWhere('id', $team_id);
        $bahasas = DB::select('SELECT distinct bahasas.id, bahasas.bahasa FROM bahasas 
        left join team_bahasas on bahasas.id = team_bahasas.bahasa_id
        where bahasas.id not in
            (select bahasa_id from team_bahasas where team_bahasas.team_id = ?)', [$team_id] );
        $team_bahasa=Team_bahasa::limit(1)->get();
        return view('teams.team_bahasas.create', compact('team_bahasa', 'team','bahasas'));
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
            'team_id' => $request->team_id,
            'bahasa_id' => $request->bahasa_id,
        ]);
        return redirect('/team_bahasas/' . $request->team_id ) ->with('status','Saved');
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
    public function edit(Team_bahasa $team_bahasa)
    {
        $team = Team::firstWhere('id', $team_bahasa->team_id);
        $bahasas = Bahasa::all()->sortBy('bahasa');
        return view('teams.team_bahasas.edit', compact('team_bahasa', 'team','bahasas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team_bahasa $team_bahasa)
    {
        Team_bahasa::where('id',$team_bahasa->id)->update([
            'team_id' => $request->team_id,
            'bahasa_id' => $request->bahasa_id,
        ]);
        return redirect('/team_bahasas/' . $request->team_id ) ->with('status','Saved');
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
        return redirect('/team_bahasas/' . $teamBahasa->team_id ) ->with('status','Deleted');
    }
}
