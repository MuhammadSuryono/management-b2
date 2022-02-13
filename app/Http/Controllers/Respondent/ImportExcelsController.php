<?php

namespace App\Http\Controllers\Respondent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Import_excel;
use App\Respondent;
use App\Imports\tmpRespondentsImport;
use App\Project;
use App\Project_imported;
use App\Tmp_Respondent;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ImportExcelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $add_url = url('/import_excels/create');
        $add_title = "Import Excel";
        $import_excels = Import_excel::all()->sortBy('created_at');
        return view('respondents.import_excels.index', compact('import_excels', 'add_url', 'add_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $import_excel = Import_excel::first();
        return view('respondents.import_excels.create', compact('import_excel'));
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
            'excel_file' => 'required',
        ]);

        if (Import_excel::all()->count() > 0) {
            $ketemu = Import_excel::where('excel_file', $request->file('excel_file')
                ->getClientOriginalName())->get()->count();
            if ($ketemu > 0)
                return redirect('/import_excels')->with('status', 'File excel pernah diload');
        }
        // Import_excel::create($request->all());
        DB::table('tmp_respondents')->truncate();
        Excel::import(new tmpRespondentsImport, $request->excel_file);

        // Save log to import_excels
        Import_excel::create([
            'excel_file' => $request->file('excel_file')->getClientOriginalName(),
            'jumlah_record' => tmp_respondent::all()->count(),
            'user_id' => session('user_id'),
        ]);

        $xid = Import_excel::where('excel_file', $request->file('excel_file')->getClientOriginalName())->first()->id;

        $checkProjectImported = Project_imported::where('project_imported',  $c1[0]->project)->get()->count();
        if ($checkProjectImported == 0)
            DB::table('project_importeds')->insert([
                'project_imported' => $c1[0]->project,
                'created_at' => time(),
                'updated_at' => time()

            ]);

        $c1 =  DB::table('tmp_respondents')->select('*')->get();
        Project_imported::create($request->all());
        foreach ($c1 as $record) {
            $idImportedProject = Project_imported::where('project_imported', '=', $record->project)->firstOrFail();
            $idProject = Project::where('nama', '=', $record->project)->firstOrFail();

            // dd($idImportedProject->nama);
            DB::table('respondents')->insert([
                'project_imported_id' => $idImportedProject->id,
                'project_id' => $idProject->id,
                'intvdate' => $record->intvdate,
                'ses_a_id' => $record->ses_a,
                'ses_b_id' => $record->ses_b,
                'ses_final_id' => $record->finalses,
                'respname' => $record->respname,
                'address' => $record->address,
                'kota_id' => $record->cityresp,
                'kelurahan_id' => $record->kelurahan,
                'mobilephone' => $record->mobilephone,
                'email' => $record->email,
                'gender_id' => $record->gender,
                'usia' => $record->usia,
                'pendidikan_id' => $record->education,
                'pekerjaan_id' => $record->occupation,
                'is_valid_id' => 0,
                'import_excel_id' => $xid,
                'sbjnum' =>  $record->sbjnum,
                'pewitness' => $record->pewitness,
                'srvyr' => $record->srvyr,
                'vstart' => $record->vstart,
                'vend' => $record->vend,
                'pilot' => $record->pilot,
                'rekaman' => $record->rekaman,
                'duration' => $record->duration,
                'latitude' => $record->latitude,
                'longitude' => $record->longitude,
                'upload' => $record->upload,
                'tanggal_upload' => time(),
                'created_at' => time(),
                'updated_at' => time()
            ]);
        }
        // dd($xid);
        DB::statement('call import_tmp_respondents(' . $xid .   ')');
        $tot_rec = Respondent::where('import_excel_id', $xid)->count();
        Import_excel::where('id', $xid)->update(['jumlah_record' => $tot_rec]);
        return redirect('\import_excels')->with('status', 'Data sudah diimport');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Import_excel  $import_excels
     * @return \Illuminate\Http\Response
     */
    public function show(Import_excel $import_excels)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Import_excel  $import_excels
     * @return \Illuminate\Http\Response
     */
    public function edit(Import_excel $import_excel)
    {
        return view('respondents.import_excels.edit', compact('import_excel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Import_excel  $import_excels
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Import_excel $import_excel)
    {
        // Import_excel::where('import_excelsid',$import_excels->import_excelsid)
        //     ->update([
        //         'excel_file'=>$request->excel_file,
        //         'jumlah_record'=>$request->jumlah_record,
        //         'user_id'=>$request->user_id,
        //     ]);
        return redirect('/import_excels')->with('status', 'Data tidak bisa diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Import_excel  $import_excels
     * @return \Illuminate\Http\Response
     */
    public function destroy(Import_excel $import_excels)
    {
        //
    }

    public function delete($id)
    {
        $affectedRows = Respondent::where('import_excel_id', $id)->delete();
        Import_excel::destroy($id);
        return redirect('/import_excels')->with('status', $affectedRows . ' records deleted successfully');
    }
}
