<?php

namespace App\Http\Controllers\Team;
use App\Http\Controllers\Controller;
use App\Team_jabatan;
use App\Team;
use App\Jabatan;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamJabatansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($team_id)
    {
        $team = Team::firstWhere('id', $team_id);
        $team_jabatans = Team_jabatan::where('team_id', $team_id)->get();
        $add_url=url('/team_jabatans/create/'.$team_id);
        return view('teams.team_jabatans.index', compact('team_jabatans','team','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($team_id)
    {
        $team = Team::firstWhere('id', $team_id);
        $jabatans = DB::select('SELECT distinct jabatans.id, jabatans.jabatan FROM jabatans 
        left join team_jabatans on jabatans.id = team_jabatans.jabatan_id
        where jabatans.id not in
            (select jabatan_id from team_jabatans where team_jabatans.team_id = ?)', [$team_id] );
        $team_jabatan=Team_jabatan::limit(1)->get();
        return view('teams.team_jabatans.create', compact('team_jabatan', 'team','jabatans'));
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
            'team_id' => $request->team_id,
            'jabatan_id' => $request->jabatan_id,
        ]);
        return redirect('/team_jabatans/' . $request->team_id ) ->with('status','Saved');
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
    public function edit(Team_jabatan $team_jabatan)
    {
        $team = Team::firstWhere('id', $team_jabatan->team_id);
        $jabatans = Jabatan::all()->sortBy('jabatan');
        return view('teams.team_jabatans.edit', compact('team_jabatan', 'team','jabatans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team_jabatan  $teamJabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team_jabatan $team_jabatan)
    {
        Team_jabatan::where('id',$team_jabatan->id)->update([
            'team_id' => $request->team_id,
            'jabatan_id' => $request->jabatan_id,
        ]);
        return redirect('/team_jabatans/' . $request->team_id ) ->with('status','Saved');
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
        return redirect('/team_jabatans/' . $teamJabatan->team_id ) ->with('status','Deleted');
    }
}
