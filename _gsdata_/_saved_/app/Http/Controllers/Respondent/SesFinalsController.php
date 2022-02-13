<?php

namespace App\Http\Controllers\Respondent;
use App\Http\Controllers\Controller;
use App\SesFinal;
use Illuminate\Http\Request;

class SesFinalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ses_finals=SesFinal::all();
        return view('respondents.ses_finals.index', compact('ses_finals','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ses_final=SesFinal::limit(1)->get();;
        return view('respondents.ses_finals.create', compact('ses_final'));

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
            'ses_final' => 'required|unique:ses_finals|max:60',
        ]);
        
        SesFinal::create($request->all());
        return redirect('/ses_finals')->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SesFinal  $ses_final
     * @return \Illuminate\Http\Response
     */
    public function show(SesFinal $ses_final)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SesFinal  $ses_final
     * @return \Illuminate\Http\Response
     */
    public function edit(SesFinal $ses_final)
    {
        return view('respondents.ses_finals.edit',compact('ses_final'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SesFinal  $ses_final
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SesFinal $ses_final)
    {
        $validatedData = $request->validate([
            'ses_final' => 'required|unique:ses_finals,ses_final,'. $ses_final->id . ',id|max:60',
        ]);
        echo 'ini ya'. $ses_final->id;
        SesFinal::where('id',$ses_final->id)->update([
            'ses_final'=>$request->ses_final,
        ]);
        return redirect('/ses_finals')->with('status','Data sudah diubah') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SesFinal  $ses_final
     * @return \Illuminate\Http\Response
     */
    public function destroy(SesFinal $ses_final)
    {
        //
    }

    public function delete($id)
    {
        SesFinal::destroy($id);
        return redirect('/ses_finals')->with('status', 'Data sudah dihapus');
    }
}
