<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Bahasa;
use Illuminate\Http\Request;

class BahasasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bahasas = Bahasa::all();
        $add_url = url('/bahasas/create');
        return view('teams.bahasas.index', compact('bahasas', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bahasa = Bahasa::first();
        $title = 'Tambah Bahasa';
        $create_edit = 'create';
        $action_url = url('/bahasas');
        $include_form = 'teams.bahasas.form_bahasa';
        return view('crud.open_record', compact('bahasa', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'bahasa' =>  'required|unique:bahasas|max:60',
        ]);

        Bahasa::create($request->all());
        return redirect('/bahasas')->with('status', 'Data sudah disimpan');
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
    public function edit(Bahasa $bahasa)
    {
        $title = 'Edit Bahasa';
        $create_edit = 'edit';
        $action_url = url('/bahasas') . '/' . $bahasa->id;
        $include_form = 'teams.bahasas.form_bahasa';
        return view('crud.open_record', compact('bahasa', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bahasa  $bahasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bahasa $bahasa)
    {
        $validatedData = $request->validate([
            'bahasa' => 'required|unique:bahasas,bahasa,' . $bahasa->id . ',id|max:60',
        ]);
        Bahasa::where('id', $bahasa->id)->update([
            'bahasa' => $request->bahasa,
        ]);
        return redirect('/bahasas')->with('status', 'Data sudah diubah');
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
        Bahasa::destoyr($id);
        return redirect('/bahasas')->with('status', 'Data sudah dihapus');
    }
}
