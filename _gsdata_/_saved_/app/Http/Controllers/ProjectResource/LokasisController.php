<?php

namespace App\Http\Controllers\ProjectResource;
use App\Http\Controllers\Controller;
use App\Lokasi;
use Illuminate\Http\Request;

class LokasisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lokasis=Lokasi::all();
        $add_url=url('/lokasis/create');
        return view('project_resources.lokasis.index', compact('lokasis','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi=Lokasi::limit(1)->get();;
        return view('project_resources.lokasis.create', compact('lokasi'));
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
            'lokasi' => 'required|unique:lokasis|max:45',
        ]);
        Lokasi::create([
            'lokasi'=>$request->lokasi,
            'updated_by_id'=>session('user_id')
        ]);
        return redirect('/lokasis')->with('status','Data sudah disimpan') ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Lokasi $lokasi)
    {
        return view('project_resources.lokasis.edit',compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lokasi $lokasi)
    {
        $validatedData = $request->validate([
            'lokasi' => 'required|unique:lokasis,lokasi,'. $lokasi->id . ',id|max:100',
        ]);
        Lokasi::where('id',$lokasi->id)->update([
            'lokasi'=>$request->lokasi,
            'updated_by_id'=>session('user_id')
        ]);
        return redirect('/lokasis')->with('status','Data sudah diubah') ;
    }

    public function delete($id)
    {
        Lokasi::destroy($id);
        return redirect('/lokasis')->with('status', 'Data sudah dihapus');
    }
}
