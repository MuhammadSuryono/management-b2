<?php

namespace App\Http\Controllers\Respondent;
use App\Http\Controllers\Controller;
use App\SesB;
use Illuminate\Http\Request;

class SesBsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ses_bs=SesB::all();
        return view('respondents.ses_bs.index', compact('ses_bs','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ses_b=SesB::limit(1)->get();;
        return view('respondents.ses_bs.create', compact('ses_b'));

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
            'ses_b' => 'required|unique:ses_bs|max:60',
        ]);
        
        SesB::create($request->all());
        return redirect('/ses_bs')->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SesB  $ses_b
     * @return \Illuminate\Http\Response
     */
    public function show(SesB $ses_b)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SesB  $ses_b
     * @return \Illuminate\Http\Response
     */
    public function edit(SesB $ses_b)
    {
        return view('respondents.ses_bs.edit',compact('ses_b'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SesB  $ses_b
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SesB $ses_b)
    {
        $validatedData = $request->validate([
            'ses_b' => 'required|unique:ses_bs,ses_b,'. $ses_b->id . ',id|max:60',
        ]);
        echo 'ini ya'. $ses_b->id;
        SesB::where('id',$ses_b->id)->update([
            'ses_b'=>$request->ses_b,
        ]);
        return redirect('/ses_bs')->with('status','Data sudah diubah') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SesB  $ses_b
     * @return \Illuminate\Http\Response
     */
    public function destroy(SesB $ses_b)
    {
        //
    }

    public function delete($id)
    {
        SesB::destroy($id);
        return redirect('/ses_bs')->with('status', 'Data sudah dihapus');
    }
}
