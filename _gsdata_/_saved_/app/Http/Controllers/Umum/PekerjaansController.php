<?php

namespace App\Http\Controllers\Umum;
use App\Http\Controllers\Controller;
use App\Pekerjaan;
use Illuminate\Http\Request;
class PekerjaansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pekerjaans=Pekerjaan::all();
        $add_url=url('/pekerjaans/create');
        $tot_pekerjaan_responden=15;
        return view('umums.pekerjaans.index', compact('pekerjaans','tot_pekerjaan_responden','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pekerjaan=Pekerjaan::limit(1)->get();;
        return view('umums.pekerjaans.create', compact('pekerjaan'));

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
        return redirect('/pekerjaans')->with('status','Data sudah disimpan') ;
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
        return view('umums.pekerjaans.edit',compact('pekerjaan'));
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
            'pekerjaan' => 'required|unique:pekerjaans,pekerjaan,'. $pekerjaan->id . ',id|max:60',
        ]);
        Pekerjaan::where('id',$pekerjaan->id)->update([
            'pekerjaan'=>$request->pekerjaan,
        ]);
        return redirect('/pekerjaans')->with('status','Data sudah diubah') ;
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
