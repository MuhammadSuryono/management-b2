<?php

namespace App\Http\Controllers\Team;

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
        $layanans = Layanan::all();
        $add_url = url('/layanans/create');
        // $tot_pekerjaan_responden = 15;
        return view('teams.layanans.index', compact('layanans', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $layanan = Layanan::first();
        $title = 'Tambah Penyedia Layanan';
        $create_edit = 'create';
        $action_url = url('/layanans');
        $include_form = 'teams.layanans.form_layanan';
        return view('crud.open_record', compact('layanan', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'layanan' => 'required|unique:layanans|max:60',
        ]);

        Layanan::create($request->all());
        return redirect('/layanans')->with('status', 'Data sudah disimpan');
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
    public function edit(Layanan $layanan)
    {
        $title = 'Edit Layanan';
        $create_edit = 'edit';
        $action_url = url('/layanans') . '/' . $layanan->id;
        $include_form = 'teams.layanans.form_layanan';
        return view('crud.open_record', compact('layanan', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pekerjaan  $pekerjaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Layanan $layanan)
    {
        $validatedData = $request->validate([
            'layanan' => 'required|unique:layanans,layanan,' . $layanan->id . ',id|max:60',
        ]);
        Layanan::where('id', $layanan->id)->update([
            'layanan' => $request->layanan,
        ]);
        return redirect('/layanans')->with('status', 'Data sudah diubah');
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
        Layanan::destroy($id);
        return redirect('/layanans')->with('status', 'Data sudah dihapus');
    }
}
