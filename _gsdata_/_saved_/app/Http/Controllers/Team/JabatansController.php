<?php

namespace App\Http\Controllers\Team;
use App\Http\Controllers\Controller;
use App\Jabatan;
use Illuminate\Http\Request;

class JabatansController extends Controller
{
    /**
     * Display a listing of the jabatan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatans=Jabatan::all();
        $add_url=url('/jabatans/create');
        return view('teams.jabatans.index', compact('jabatans','add_url'));
    }

    /**
     * Show the form for creating a new jabatan.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatan=Jabatan::limit(1)->get();;
        return view('teams.jabatans.create', compact('jabatan'));

    }

    /**
     * Store a newly created jabatan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $validatedData = $request->validate([
            'jabatan' => 'required|unique:jabatans|max:60',
        ]);
        
        Jabatan::create($request->all());
        return redirect('/jabatans')->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified jabatan.
     *
     * @param  \App\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified jabatan.
     *
     * @param  \App\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        return view('teams.jabatans.edit',compact('jabatan'));
    }

    /**
     * Update the specified jabatan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $validatedData = $request->validate([
            'jabatan' => 'required|unique:jabatans,jabatan,'. $jabatan->id . ',id|max:60',
        ]);
        echo 'ini ya'. $jabatan->id;
        Jabatan::where('id',$jabatan->id)->update([
            'jabatan'=>$request->jabatan,
        ]);
        return redirect('/jabatans')->with('status','Data sudah diubah') ;
    }

    /**
     * Remove the specified jabatan from storage.
     *
     * @param  \App\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jabatan $jabatan)
    {
        //
    }

    public function delete($id)
    {
        Jabatan::destroy($id);
        return redirect('/jabatans')->with('status', 'Data sudah dihapus');
    }
}
