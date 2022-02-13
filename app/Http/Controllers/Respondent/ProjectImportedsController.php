<?php

namespace App\Http\Controllers\Respondent;

use App\Http\Controllers\Controller;
use App\Project_imported;
use Illuminate\Http\Request;

class ProjectImportedsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project_importeds = Project_imported::all();
        return view('respondents.project_importeds.index', compact('project_importeds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project_imported = Project_imported::first();;
        return view('respondents.project_importeds.create', compact('project_imported'));
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
            'project_imported' => 'required|unique:project_importeds|max:60',
        ]);

        Project_imported::create($request->all());
        return redirect('/project_importeds')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project_imported  $project_imported
     * @return \Illuminate\Http\Response
     */
    public function show(Project_imported $project_imported)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project_imported  $project_imported
     * @return \Illuminate\Http\Response
     */
    public function edit(Project_imported $project_imported)
    {
        return view('respondents.project_importeds.edit', compact('project_imported'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project_imported  $project_imported
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project_imported $project_imported)
    {
        $validatedData = $request->validate([
            'project_imported' => 'required|unique:project_importeds,project_imported,' . $project_imported->id . ',id|max:60',
        ]);
        Project_imported::where('id', $project_imported->id)->update([]);
        return redirect('/project_importeds')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project_imported  $project_imported
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project_imported $project_imported)
    {
        //
    }

    public function delete($id)
    {
        Project_imported::destroy($id);
        return redirect('/project_importeds')->with('status', 'Data sudah dihapus');
    }
}
