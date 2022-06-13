<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use App\Divisi;
use App\E_wallet;
use App\Helpers\GuzzleRequester;
use Illuminate\Http\Request;
use DB;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new GuzzleRequester();
        $client->request('GET', 'api/bank');
        $banks=$client->getBody()->data;
        $e_wallet = E_wallet::get();
        return view('umums.banks.index', compact('banks', 'e_wallet'));
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
        $include_form = 'umums.divisis.form_divisi';
        return view('crud.open_record', compact('divisi', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'nama_divisi' =>  'required|unique:divisis|max:60'
        ]);

        Divisi::create($request->all());
        return redirect('/divisis')->with('status', 'Data sudah disimpan');
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
    public function edit(Divisi $divisi)
    {
        $title = 'Edit Divisi';
        $create_edit = 'edit';
        $action_url = url('/divisis') . '/' . $divisi->id;
        $include_form = 'umums.divisis.form_divisi';
        return view('crud.open_record', compact('divisi', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bahasa  $bahasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Divisi $divisi)
    {
        $validatedData = $request->validate([
            'nama_divisi' => 'required|unique:divisis,nama_divisi,' . $divisi->id . ',id|max:60'
        ]);
        Divisi::where('id', $divisi->id)->update([
            'nama_divisi' => $request->nama_divisi
        ]);
        return redirect('/divisis')->with('status', 'Data sudah diubah');
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
        Divisi::destroy($id);
        return redirect('/divisis')->with('status', 'Data sudah dihapus');
    }
}
