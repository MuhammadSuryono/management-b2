<?php

namespace App\Http\Controllers\Team;
use App\Http\Controllers\Controller;
use App\Team;
use App\Gender;
use App\Kota;
use App\Pendidikan;
use App\Pekerjaan;
use App\User;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams=Team::all();
        $add_url=url('/teams/create');
        return view('teams.teams.index', compact('teams','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $team=Team::first();
        $genders=Gender::all(); $kotas=Kota::all();
        $pendidikans=Pendidikan::all(); $pekerjaans=Pekerjaan::all();
        $users=User::all();
        $tgl_skr = date("Y-m-d");
        $title='Tambah Team';
        $create_edit='create';
        $action_url=url('/teams');
        $include_form='teams.teams.form_team';
        return view('crud.open_record', compact('team','genders','kotas',
        'pendidikans','pekerjaans','users','tgl_skr','title','create_edit','action_url','include_form'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $validatedData = $request->validate([
            'nama' => 'required|unique:teams|max:60',
            'gender_id' => 'required',
            'ktp' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|unique:teams',
            'alamat' => 'required',
            'kota_id' => 'required',
            'tgl_lahir' => 'required',
            'pendidikan_id' => 'required',
            'pekerjaan_id' => 'required',
            'tgl_registrasi' => 'required',
            ]);
        
        Team::create([
            'user_id'=>$request->user_id,
            'no_team'=>Team::where('kota_id', $request->kota_id)->max('no_team') + 1,
            'nama'=>$request->nama,
            'gender_id'=>$request->gender_id,
            'ktp'=>$request->ktp,
            'hp'=>$request->hp,
            'email'=>$request->email,
            'alamat'=>$request->alamat,
            'kota_id'=>$request->kota_id,
            'tgl_lahir'=>$request->tgl_lahir,
            'pekerjaan_id'=>$request->pekerjaan_id,
            'pendidikan_id'=>$request->pendidikan_id,
            'tgl_registrasi'=>$request->tgl_registrasi,
            'updated_by_id'=>session('user_id')

        ]);
        return redirect('/teams')->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $genders=Gender::all(); $kotas=Kota::all();
        $pendidikans=Pendidikan::all(); $pekerjaans=Pekerjaan::all();
        $users=User::all();
        $title='Edit Team';
        $create_edit='Edit';
        $action_url=url('/teams') .'/' . $team->id;
        $include_form='teams.teams.form_team';
        return view('crud.open_record', compact('team','genders','kotas',
        'pendidikans','pekerjaans','users','title','create_edit','action_url','include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $validatedData = $request->validate([
            'nama' => 'required|unique:teams,nama,'. $team->id . ',id|max:60',
            'gender_id' => 'required',
            'ktp' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|unique:teams,email,'. $team->id . ',id|max:60',
            'alamat' => 'required',
            'kota_id' => 'required',
            'tgl_lahir' => 'required',
            'pendidikan_id' => 'required',
            'pekerjaan_id' => 'required',
            'tgl_registrasi' => 'required',
            ]);

        Team::where('id',$team->id)->update([
            'user_id'=>$request->user_id,
            'nama'=>$request->nama,
            'gender_id'=>$request->gender_id,
            'ktp'=>$request->ktp,
            'hp'=>$request->hp,
            'email'=>$request->email,
            'alamat'=>$request->alamat,
            'kota_id'=>$request->kota_id,
            'tgl_lahir'=>$request->tgl_lahir,
            'pekerjaan_id'=>$request->pekerjaan_id,
            'pendidikan_id'=>$request->pendidikan_id,
            'tgl_registrasi'=>$request->tgl_registrasi,
            'updated_by_id'=>session('user_id')

        ]);
        return redirect('/teams')->with('status','Data sudah diubah') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }

    public function delete($id)
    {
        Team::destroy($id);
        return redirect('/teams')->with('status','Data sudah dihapus') ;
    }
}
