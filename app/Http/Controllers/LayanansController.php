<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Layanan;
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
        $layanan = Layanan::all();
        $add_url = url('/layanans/create');
        // $tot_pekerjaan_responden = 15;
        return view('umums.layanans.index', compact('layanans', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pekerjaan = Pekerjaan::first();
        $title = 'Tambah Pekerjaan';
        $create_edit = 'create';
        $action_url = url('/pekerjaans');
        $include_form = 'umums.pekerjaans.form_pekerjaan';
        return view('crud.open_record', compact('pekerjaan', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'pekerjaan' => 'required|unique:pekerjaans|max:60',
        ]);

        Pekerjaan::create($request->all());
        return redirect('/pekerjaans')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pekerjaan  $pekerjaan
     * @return \Illuminate\Http\Response
     */
    public function show(Pekerjaan $pekerjaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pekerjaan  $pekerjaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pekerjaan $pekerjaan)
    {
        $title = 'Edit Pekerjaan';
        $create_edit = 'edit';
        $action_url = url('/pekerjaans') . '/' . $pekerjaan->id;
        $include_form = 'umums.pekerjaans.form_pekerjaan';
        return view('crud.open_record', compact('pekerjaan', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pekerjaan  $pekerjaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pekerjaan $pekerjaan)
    {
        $validatedData = $request->validate([
            'pekerjaan' => 'required|unique:pekerjaans,pekerjaan,' . $pekerjaan->id . ',id|max:60',
        ]);
        Pekerjaan::where('id', $pekerjaan->id)->update([
            'pekerjaan' => $request->pekerjaan,
        ]);
        return redirect('/pekerjaans')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pekerjaan  $pekerjaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pekerjaan $pekerjaan)
    {
        //
    }

    public function delete($id)
    {
        Pekerjaan::destroy($id);
        return redirect('/pekerjaans')->with('status', 'Data sudah dihapus');
    }
}
