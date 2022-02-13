<?php

namespace App\Http\Controllers\Respondent;
use App\Http\Controllers\Controller;
use App\SesA;
use Illuminate\Http\Request;

class SesAsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ses_as=SesA::all();
        return view('respondents.ses_as.index', compact('ses_as','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ses_a=SesA::limit(1)->get();;
        return view('respondents.ses_as.create', compact('ses_a'));

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
            'ses_a' => 'required|unique:ses_as|max:60',
        ]);
        
        SesA::create($request->all());
        return redirect('/ses_as')->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SesA  $ses_a
     * @return \Illuminate\Http\Response
     */
    public function show(SesA $ses_a)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SesA  $ses_a
     * @return \Illuminate\Http\Response
     */
    public function edit(SesA $ses_a)
    {
        return view('respondents.ses_as.edit',compact('ses_a'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SesA  $ses_a
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SesA $ses_a)
    {
        $validatedData = $request->validate([
            'ses_a' => 'required|unique:ses_as,ses_a,'. $ses_a->id . ',id|max:60',
        ]);
        SesA::where('id',$ses_a->id)->update([
            'ses_a'=>$request->ses_a,
        ]);
        return redirect('/ses_as')->with('status','Data sudah diubah') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SesA  $ses_a
     * @return \Illuminate\Http\Response
     */
    public function destroy(SesA $ses_a)
    {
        //
    }

    public function delete($id)
    {
        SesA::destroy($id);
        return redirect('/ses_as')->with('status', 'Data sudah dihapus');
    }
}
