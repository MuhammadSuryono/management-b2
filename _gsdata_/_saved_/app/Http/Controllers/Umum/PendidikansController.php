<?php

namespace App\Http\Controllers\Umum;
use App\Http\Controllers\Controller;
use App\Pendidikan;
use Illuminate\Http\Request;

class PendidikansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pendidikans=Pendidikan::all();
        $add_url=url('/pendidikans/create');
        $tot_pendidikan_responden=7;
        return view('umums.pendidikans.index', compact('pendidikans','tot_pendidikan_responden','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pendidikan=Pendidikan::limit(1)->get();;
        return view('umums.pendidikans.create', compact('pendidikan'));

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
            'pendidikan' => 'required|unique:pendidikans|max:60',
        ]);
        
        Pendidikan::create($request->all());
        return redirect('/pendidikans')->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function show(Pendidikan $pendidikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pendidikan $pendidikan)
    {
        return view('umums.pendidikans.edit',compact('pendidikan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pendidikan $pendidikan)
    {
        $validatedData = $request->validate([
            'pendidikan' => 'required|unique:pendidikans,pendidikan,'. $pendidikan->id . ',id|max:60',
        ]);
        echo 'ini ya'. $pendidikan->id;
        Pendidikan::where('id',$pendidikan->id)->update([
            'pendidikan'=>$request->pendidikan,
        ]);
        return redirect('/pendidikans')->with('status','Data sudah diubah') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pendidikan $pendidikan)
    {
        //
    }

    public function delete($id)
    {
        Pendidikan::destroy($id);
        return redirect('/pendidikans')->with('status', 'Data sudah dihapus');
    }
}
