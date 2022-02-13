<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Bahasa;
use App\Divisi;
use App\Keahlian;
use Illuminate\Http\Request;

class LayanansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return 'test';
        dd('here');
        $keahlian = Keahlian::all();
        $add_url = url('/keahlian/create');
        return view('teams.keahlian.index', compact('keahlian', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisi = Divisi::first();
        $title = 'Tambah Divisi';
        $create_edit = 'create';
        $action_url = url('/divisis');
        $include_form = 'teams.keahlian.form_keahlian';
        return view('crud.open_record', compact('keahlian', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'keahlian' =>  'required|unique:keahlians|max:60',
        ]);

        Keahlian::create($request->all());
        return redirect('/keahlian')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bahasa  $bahasa
     * @return \Illuminate\Http\Response
     */
    public function show(Bahasa $bahasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bahasa  $bahasa
     * @return \Illuminate\Http\Response
     */
    public function edit(Keahlian $keahlian)
    {
        $title = 'Edit Keahlian';
        $create_edit = 'edit';
        $action_url = url('/keahlian') . '/' . $keahlian->id;
        $include_form = 'teams.keahlian.form_keahlian';
        return view('crud.open_record', compact('keahlian', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bahasa  $bahasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keahlian $keahlian)
    {
        $validatedData = $request->validate([
            'keahlian' => 'required|unique:keahlians,keahlian,' . $keahlian->id . ',id|max:60',
        ]);
        Keahlian::where('id', $keahlian->id)->update([
            'keahlian' => $request->keahlian,
        ]);
        return redirect('/keahlian')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bahasa  $bahasa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bahasa $bahasa)
    {
        //
    }

    public function delete($id)
    {
        Keahlian::destroy($id);
        return redirect('/keahlian')->with('status', 'Data sudah dihapus');
    }
}
