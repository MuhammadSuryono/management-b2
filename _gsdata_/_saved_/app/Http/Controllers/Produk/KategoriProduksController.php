<?php

namespace App\Http\Controllers\Produk;
use App\Http\Controllers\Controller;
use App\Kategori_produk;
use Illuminate\Http\Request;
class KategoriProduksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $add_url=url('/kategori_produks/create');
        $kategori_produks = Kategori_produk::all();
        return view('produks.kategori_produks.index',compact('kategori_produks','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori_produk=Kategori_produk::limit(1)->get();
        return view('produks.kategori_produks.create', compact('kategori_produk'));
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
            'kategori_produk' => 'required|unique:kategori_produks|max:50',
        ]);

        Kategori_produk::create([
            'kategori_produk'=>$request->kategori_produk,
            'updated_by_id'=>session('user_id')
        ]);
        return redirect('/kategori_produks')->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kategori_produk  $kategori_produk
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori_produk $kategori_produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kategori_produk  $kategori_produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori_produk $kategori_produk)
    {
        return view('produks.kategori_produks.edit', compact('kategori_produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kategori_produk  $kategori_produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori_produk $kategori_produk)
    {
        //Validation
        $validatedData = $request->validate([
            'kategori_produk' => 'required|unique:kategori_produks,kategori_produk,'. $kategori_produk->id . '|max:50',
        ]);
        Kategori_produk::where('id',$kategori_produk->id)
        ->update(['kategori_produk'=>$request->kategori_produk,
        'updated_by_id'=>session('user_id')
        ]);
        return redirect('/kategori_produks')->with('status','Data sudah disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kategori_produk  $kategori_produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori_produk $kategori_produk)
    {
        //
    }
    public function delete($id) {
        Kategori_produk::destroy($id);
        return redirect('/kategori_produks')->with('status','Data sudah dihapus');
    }

}
