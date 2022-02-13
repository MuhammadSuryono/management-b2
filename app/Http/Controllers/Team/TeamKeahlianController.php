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

class TeamKeahlianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($team_id)
    {
        // return $team_id;

        $team = Team::firstWhere('id', $team_id);

        $team_keahlian = Team_keahlian::where('team_id', $team_id)->get();
        $add_url = url('/team_keahlian/create/' . $team_id);
        return view('teams.team_keahlian.index', compact('team_keahlian', 'team', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($team_id)
    {
        $team = Team::firstWhere('id', $team_id);
        $keahlian = DB::select('SELECT distinct keahlians.id, keahlians.keahlian FROM keahlians 
        left join team_keahlians on keahlians.id = team_keahlians.keahlian_id
        where keahlians.id not in
            (select keahlian_id from team_keahlians where team_keahlians.team_id = ?)', [$team_id]);
        $team_keahlian = Team_keahlian::first();
        return view('teams.team_keahlian.create', compact('team_keahlian', 'team', 'keahlian'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'keahlian_id' => 'required',
            'team_id' => 'required',
        ]);

        if (!$request->keahlian_id) {
            return redirect('/team_keahlian/' . $request->team_id)->with('status-fail', 'Gagal');
        }

        Team_keahlian::create([
            'team_id' => $request->team_id,
            'keahlian_id' => $request->keahlian_id,
        ]);
        return redirect('/team_keahlian/' . $request->team_id)->with('status', 'Saved');
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
        // $team = Team::firstWhere('id', $team_bahasa->team_id);
        // $bahasas = Bahasa::all()->sortBy('bahasa');
        // return view('teams.team_bahasas.edit', compact('team_bahasa', 'team', 'bahasas'));
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
        // Team_keahlian::where('id', $team_keahlian->id)->update([
        //     'team_id' => $request->team_id,
        //     'keahlian_id' => $request->bahasa_id,
        // ]);
        // return redirect('/team_keahlian/' . $request->team_id)->with('status', 'Saved');
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
        // return $teamKeahlian;
        Team_keahlian::destroy($teamKeahlian->id);
        return redirect('/team_keahlian/' . $teamKeahlian->team_id)->with('status', 'Deleted');
    }
}
