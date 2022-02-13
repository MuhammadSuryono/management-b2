<?php

namespace App\Http\Controllers\Produk;
use App\Tipe_produk;
use App\Nama_produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class NamaProduksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tipe_produk_id)
    {
        $tipe_produk = Tipe_produk::firstWhere('id',$tipe_produk_id);
        $nama_produks = Nama_produk::where('tipe_produk_id',$tipe_produk_id)->get();
        $add_url=url('/nama_produks/create/'.$tipe_produk_id);
        return view('produks.nama_produks.index',compact('nama_produks','add_url','tipe_produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tipe_produk_id)
    {   
        $tipe_produk = Tipe_produk::find($tipe_produk_id);
        $nama_produk=Nama_produk::first();
        return view('produks.nama_produks.create', compact('nama_produk','tipe_produk'));
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
            'nama_produk' => 'required|unique:nama_produks,nama_produk|max:50',
            'tipe_produk_id' => 'required',
        ]);

        Nama_produk::create($request->all());
        return redirect('/nama_produks/'.$request->tipe_produk_id )->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nama_produk  $nama_produk
     * @return \Illuminate\Http\Response
     */
    public function show(Nama_produk $nama_produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nama_produk  $nama_produk
     * @return \Illuminate\Http\Response
     */
    public function edit($nama_produk_id)
    {   
        $nama_produk = Nama_produk::find($nama_produk_id);
        $tipe_produk = Tipe_produk::find($nama_produk->tipe_produk_id);
        return view('produks.nama_produks.edit', compact('nama_produk', 'tipe_produk'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nama_produk  $nama_produk
     * @return \Illuminate\Htt  p\Response
     */
    public function update(Request $request, Nama_produk $nama_produk)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|unique:nama_produks,nama_produk,'. $request->nama_produk_id . '|max:50',
        ]);
        Nama_produk::where('id',$request->nama_produk_id)
        ->update([
            'nama_produk'=>$request->nama_produk,
            'updated_by_id'=>session('user_id')
        ]);
        return redirect('/nama_produks/'.$request->tipe_produk_id)->with('status','Data sudah disimpan');
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nama_produk  $nama_produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nama_produk $nama_produk)
    {
        $tipe_produk_id=$nama_produk->tipe_produk_id;
        Nama_produk::destroy($nama_produk->id);
        return redirect('/nama_produks/'.$tipe_produk_id )->with('status','Data sudah disimpan') ;
        
    }
    public function delete($id) {
        $tipe_pid=Nama_produk::firstWhere('id', $id)->tipe_produk_id;
        Nama_produk::destroy($id);
        return redirect('/nama_produks/'.$tipe_pid)->with('status','Data sudah disimpan') ;
    }
}
