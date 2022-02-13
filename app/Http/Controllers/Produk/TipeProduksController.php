<?php

namespace App\Http\Controllers\Produk;
use App\Kategori_produk;
use App\Tipe_produk;
use App\Nama_produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class TipeProduksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kategori_produk_id)
    {
        $kategori_produk = Kategori_produk::firstWhere('id',$kategori_produk_id);
        // $kategori_produk=$kategori_produk1->kategori_produk;
        $tipe_produks = Tipe_produk::where('kategori_produk_id',$kategori_produk_id)->get();
        $add_url=url('/tipe_produks/create/'.$kategori_produk_id);
        return view('produks.tipe_produks.index',compact('tipe_produks','add_url','kategori_produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($kategori_produk_id)
    {   $kategori_produk = Kategori_produk::firstWhere('id',$kategori_produk_id);
        $tipe_produk=Tipe_produk::first();
        return view('produks.tipe_produks.create', compact('tipe_produk','kategori_produk'));
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
            'tipe_produk' => 'required|unique:tipe_produks,tipe_produk|max:50',
            'kategori_produk_id' => 'required',
        ]);

        Tipe_produk::create([
            'kategori_produk_id'=>$request->kategori_produk_id,
            'tipe_produk'=>$request->tipe_produk,
            'updated_by_id'=>session('user_id')
        ]);
        return redirect('/tipe_produks/'.$request->kategori_produk_id )->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tipe_produk  $tipe_produk
     * @return \Illuminate\Http\Response
     */
    public function show(Tipe_produk $tipe_produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tipe_produk  $tipe_produk
     * @return \Illuminate\Http\Response
     */
    public function edit($tipe_produk_id)
    {   
        $tipe_produk=Tipe_produk::find($tipe_produk_id);
        $kategori_produk = Kategori_produk::firstWhere('id', $tipe_produk->kategori_produk_id);
        return view('produks.tipe_produks.edit', compact('tipe_produk','kategori_produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tipe_produk  $tipe_produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipe_produk $tipe_produk)
    {
        //Validation
        $validatedData = $request->validate([
            'tipe_produk' => 'required|unique:tipe_produks,tipe_produk,'. $request->id . '|max:50',
        ]);
        Tipe_produk::where('id',$request->tipe_produk_id)->update([
                'tipe_produk'=>$request->tipe_produk,
                'updated_by_id'=>session('user_id')
            ]);

        return redirect('/tipe_produks/'.$request->kategori_produk_id )->with('status','Data sudah disimpan') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tipe_produk  $tipe_produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipe_produk $tipe_produk)
    {
        //
    }
    public function delete($id) {
        $kategori_pid=Tipe_produk::firstWhere('id',$id)->kategori_produk_id;
        Tipe_produk::destroy($id);
        return redirect('/tipe_produks/'.$kategori_pid)->with('status','Data sudah dihapus') ;
    }
}
