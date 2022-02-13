<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use App\Kota;
use Illuminate\Http\Request;

class KotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kotas = Kota::all();
        $add_url = url('/kotas/create');
        $tot_kota_responden = 8;
        return view('umums.kotas.index', compact('kotas', 'tot_kota_responden', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kota = Kota::first();
        $title = 'Tambah Kota';
        $create_edit = 'create';
        $action_url = url('/kotas');
        $include_form = 'umums.kotas.form_kota';
        return view('crud.open_record', compact('kota', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'kota' => 'required|unique:kotas|max:60',
        ]);
        Kota::create([
            'kota' => $request->kota,
        ]);
        return redirect('/kotas')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function show(Kota $kota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function edit(Kota $kota)
    {
        $title = 'Edit Kota';
        $create_edit = 'edit';
        $action_url = url('/kotas') . '/' . $kota->id;
        $include_form = 'umums.kotas.form_kota';
        return view('crud.open_record', compact('kota', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kota $kota)
    {
        $validatedData = $request->validate([
            'kota' => 'required|unique:kotas,kota,' . $kota->id . ',id|max:60',
        ]);
        Kota::where('id', $kota->id)->update([
            'kota' => $request->kota,
        ]);
        return redirect('/kotas')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kota $kota)
    {
        //
    }

    public function delete($id)
    {
        Kota::destroy($id);
        return redirect('/kotas')->with('status', 'Data sudah dihapus');
    }
}
