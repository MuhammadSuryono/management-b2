<?php

namespace App\Http\Controllers\Respondent;
use Session;
use App\Http\Controllers\Controller;
use App\User_role;
use App\Respondent;
use App\Kota;
use App\Pendidikan;
use App\SesFinal;
use App\Gender;
use App\Pekerjaan;
use App\Project_imported;
use App\Isvalid;

use Illuminate\Http\Request;

class RespondentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $kotas = Kota::all()->sortBy('kota'); $pendidikans = Pendidikan::all()->sortBy('pendidikan');
        $ses_finals = SesFinal::all(); $genders=Gender::all(); $pekerjaans = Pekerjaan::all()->sortBy('pekerjaan');
        $project_importeds = Project_imported::all()->sortBy('project_imported');$is_valids=Isvalid::all();


        $user_role = User_role::selectRaw('distinct roles.role')
        ->join('roles','roles.id','=','user_roles.role_id')
        ->where('user_roles.user_id',[session('user_id')])
        ->where('roles.role','Administrators')
        ->get();

        if (session('link_from')=='saving')
        {
            $params = session('last_resp_param');
        } else {
            $params = $request->except('_token');
            // session(['last_resp_param' => $params]);
            Session::put('last_resp_param', $params);
        }
        session(['link_from'=>'menu']);
        $respondents = Respondent::filter($params)->get();
        return view('respondents.respondents.index', compact('respondents','kotas','pendidikans','ses_finals',
        'genders','pekerjaans','project_importeds','is_valids','user_role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function show(Respondent $respondent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function edit(Respondent $respondent)
    {   $kotas = Kota::all(); $pendidikans = Pendidikan::all();
        $ses_finals = SesFinal::all(); $genders=Gender::all(); $pekerjaans = Pekerjaan::all();
        $project_importeds = Project_imported::all();$is_valids=Isvalid::all();

        return view('respondents.respondents.edit',compact('respondent','kotas','pendidikans','ses_finals',
        'genders','pekerjaans','project_importeds','is_valids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Respondent $respondent)
    {
        Respondent::where('id',$respondent->id)->update([
            'ses_final_id'=>$request->ses_final_id,
            'respname'=>$request->respname,
            'address'=>$request->address,
            'kota_id'=>$request->kota_id,
            'mobilephone'=>$request->mobilephone,
            'email'=>$request->email,
            'gender_id'=>$request->gender_id,
            'pendidikan_id'=>$request->pendidikan_id,
            'pekerjaan_id'=>$request->pekerjaan_id,
            'is_valid_id'=>$request->is_valid_id,
            'updated_by_id'=>session('user_id')

        ]);
        session(['link_from'=>'saving']);
        return redirect('/respondents')->with('status','Data sudah diubah') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Respondent $respondent)
    {
        //
    }
}
