<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use App\Kelurahan;
use App\Kota;
use Illuminate\Http\Request;

class KelurahansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelurahans = Kelurahan::all();
        $add_url = url('/kelurahans/create');
        return view('umums.kelurahans.index', compact('kelurahans', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kotas = Kota::orderBy('kota', 'asc')->get();
        $kelurahan = Kelurahan::all();
        $title = 'Tambah Kelurahan';
        $create_edit = 'create';
        $action_url = url('/kelurahans');
        $include_form = 'umums.kelurahans.form_kelurahan';
        return view('crud.open_record', compact('kotas', 'kelurahan', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'kelurahan' => 'required|unique:kelurahans|max:60',
        ]);
        Kelurahan::create([
            'kota_id' => $request->kota_id,
            'kelurahan' => $request->kelurahan,
        ]);
        return redirect('/kelurahans')->with('status', 'Data sudah disimpan');
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
    public function edit(Kelurahan $kelurahan)
    {
        $kotas = Kota::orderBy('kota', 'asc')->get();
        $title = 'Edit Kelurahan';
        $create_edit = 'edit';
        $action_url = url('/kelurahans') . '/' . $kelurahan->id;
        $include_form = 'umums.kelurahans.form_kelurahan';
        return view('crud.open_record', compact('kelurahan', 'kotas', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelurahan $kelurahan)
    {
        $validatedData = $request->validate([
            'kelurahan' => 'required|unique:kelurahans,kelurahan,' . $kelurahan->id . ',id|max:60',
        ]);
        Kota::where('id', $kelurahan->id)->update([
            'kota_id' => $request->kota_id,
            'kelurahan' => $request->kelurahan,
        ]);
        return redirect('/kelurahans')->with('status', 'Data sudah diubah');
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
