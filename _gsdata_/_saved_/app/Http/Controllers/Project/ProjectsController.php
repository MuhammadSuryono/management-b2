<?php

namespace App\Http\Controllers\Project;
use App\Http\Controllers\Controller;
use App\Customer2;
use App\Project;
use App\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // PAK BUDI
        // $customers=Customer2::all()->sortBy('nama');
        // $projects=Project::all()->sortBy('project_date');
        // $add_url=url('/projects/create');
        // return view('projects.projects.index', compact('projects','customers','add_url'));
        // AKHIR PADK BUDI

        // IWAYRIWAY
        $projects = DB::table('projects')->select('*')
                     ->whereNotNull(['nama', 'kode_project'])
                     ->get();

        $add_url=url('/projects/create');
        $customers=Customer2::all()->sortBy('nama');

        return view('projects.projects.index', compact('projects','customers','add_url'));
        // AKHIR IWAYRIWAY
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // PAK BUDI
        // $customers = Customer2::all()->sortBy('nama');
        // $project=Project::limit(1)->get();
        // return view('projects.projects.create', compact('project','customers'));
        // AKHIR PAK BUDI

        // IwayRiway
        $projects = DB::table('projects')->select('nomor_rfq')
                     ->whereNull(['nama', 'kode_project'])
                     ->groupBy('nomor_rfq')
                     ->get();

        return view('projects.projects.createIwayRiway', compact('projects'));
        // AKHIR IwayRiway

    }


    public function ambilData()
    {
       $nomor_rfq = $_POST['nomor_rfq'];

       $data = DB::table('projects')->select('*')
                    ->where('nomor_rfq', '=', $nomor_rfq)
                    ->whereNull(['nama', 'kode_project'])
                    ->get();

       echo json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buatProject(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $time = date('Y-m-d H:i:s');

        DB::table('projects')
            ->where('id', '=', $request->method)
            ->update([
                    'nama' => $request->nama_project,
                    'kode_project' => $request->kode_project,
                    'tgl_kickoff' => $request->tgl_kickoff,
                    'tgl_akhir_kontrak' => $request->tgl_akhir_kontrak,
                    'tgl_approve_kuesioner' => $request->tgl_approve_kuesioner,
                    'ket' => $request->ket,
                    'user_id' => session('user_id'),
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);

        // INSERT KE BUDGET
        $data = DB::connection('mysql2')->table('tb_user')->where('id_user', '=', session('user_login'))->first();
        DB::connection('mysql2')
                    ->table('pengajuan')
                    ->insert([
                        'jenis' => 'B2', 
                        'nama' => $request->nama_project,
                        'tahun' => date('Y'),
                        'pengaju' => $data->nama_user,
                        'divisi' => $data->divisi,
                        'status' => 'Belum Di Ajukan',
                        'waktu' => $time,
                        'kodeproject' => $request->kode_project,
                        'is_laravel' => '1',
                    ]);
        // AKHIR INSERT

        return redirect('/projects')->with('status','Data sudah disimpan') ;
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        // dd(date('Y-m-d H:i:s'));
        //Validation
        $validatedData = $request->validate([
            'nama' => 'required|unique:projects|max:50',
            'customer_id' => 'required',
            'project_date' => 'required',
            'date_start_target' => 'required',
            'date_finish_target' => 'required',
            'ket' => 'required',
        ]);
        Project::create([
            'nama' => $request->nama_project,
            'kode_project' => $request->kode_project,
            'tgl_kickoff' => $request->tgl_kickoff,
            'tgl_akhir_kontrak' => $request->tgl_akhir_kontrak,
            'tgl_approve_kuesioner' => $request->tgl_approve_kuesioner,
            'user_id' => session('user_id'),
            'ket' => $request->ket,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by_id'=>session('user_id')
        ]);

        // INSERT DB BUDGET
        $nama = new Budget();
        $nama = $nama->getDivisi();
        DB::connection('mysql2')->table('pengajuan')
                                ->insert([
                                    'jenis' => 'B2',
                                    'nama' => $request->nama,
                                    'tahun' => date('Y'),
                                    'pengaju' => $nama->nama_user,
                                    'divisi' => $nama->divisi,
                                    'totalbudget' => '0',
                                    'totalbudgetnow' => '0',
                                    'status' => 'Belum Di Ajukan',
                                    'waktu' => date('Y-m-d H:i:s'),
                                    'kodeproject' => '',
                                    'is_laravel' => '1',
                                ]);
        // AKHIR INSERT DB BUDGET

        return redirect('/projects')->with('status','Data sudah disimpan') ;
    }


    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $project
     * @return \Illuminate\Http\Response
     */

     public function edit(Project $project)
    {
        // PAK BUDI
        // session([
        //     'current_project_id'=>$project->id,
        //     'current_project_nama'=>$project->nama
        // ]);
        // $customers = Customer2::all()->sortBy('nama');
        // return view('projects.projects.edit',compact('project','customers'));
        // AKHIR PAK BUDI

        // IWAYRIWAY
        return view('projects.projects.edit',compact('project'));
        // AKHIR IWAYRIWAY
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // PAK BUDI
        // //Validation
        // $validatedData = $request->validate([
        //     'nama' => 'required|unique:projects,nama,'. $project->id . ',id|max:50',
        //     'customer_id' => 'required',
        //     'project_date' => 'required',
        //     'date_start_target' => 'required',
        //     'date_finish_target' => 'required',
        //     'ket' => 'required',
        // ]);
        // Project::where('id',$project->id)->update([
        //     'user_id'=>$request->user_id,
        //     'nama'=>$request->nama,
        //     'customer_id'=>$request->customer_id,
        //     'project_date'=>$request->project_date,
        //     'date_start_target'=>$request->date_start_target,
        //     'date_finish_target'=>$request->date_finish_target,
        //     'date_start_real'=>$request->date_start_real,
        //     'date_finish_real'=>$request->date_finish_real,
        //     'ket'=>$request->ket,
        // ]);
        // return redirect('/projects')->with('status','Data sudah diubah') ;
        // AKHIR PAK BUDI

        // IWAYRIWAY
            date_default_timezone_set('Asia/Jakarta');
        // UPDATE TBL PROJECT B2
            DB::table('projects')
                ->where('id', '=', $project->id)
                ->update([
                    'nama' => $request->nama_project,
                    'kode_project' => $request->kode_project,
                    'tgl_kickoff' => $request->tgl_kickoff,
                    'tgl_akhir_kontrak' => $request->tgl_akhir_kontrak,
                    'tgl_approve_kuesioner' => $request->tgl_approve_kuesioner,
                    'user_id' => session('user_id'),
                    'ket' => $request->ket,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by_id'=>session('user_id')
                ]);
        // AKHIR

        // UPDATE TBL PENGAJUAN BUDGET
            DB::connection('mysql2')->table('pengajuan')
                ->where('waktu', '=', $project->created_at)
                ->update([
                    'nama' => $request->nama_project,
                    'kodeproject' => $request->kode_project,
                ]);    
        // AKHIR

            return redirect('/projects')->with('status','Data sudah diubah');
        // AKHIR IWAYRIWAY
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $project)
    {
        //
    }

    public function delete($id)
    {
        // HAPUS PENGAJUAN BUDGET
        $waktu = Project::find($id);
        DB::connection('mysql2')->table('pengajuan')
            ->where('waktu', '=', $waktu->created_at)
            ->delete();
        // AKHIR HAPUS PENGAJUAN BUDGET

        // UPDATE DATA PROJECT B2
        DB::table('projects')
            ->where('id', '=', $id)
            ->update([
                'nama' => null,
                'kode_project' => null,
                'tgl_kickoff' => null,
                'tgl_akhir_kontrak' => null,
                'tgl_approve_kuesioner' => null,
                'ket' => null,
                'user_id' => null,
                'created_at' => null,
                'updated_at' => null,
            ]);
        // AKHIR UPDATE DATA PROJECT B2

        // Project::destroy($id);
        return redirect('/projects')->with('status','Data sudah dihapus') ;
    }

    public function scan_qr()
    {
        return "Scan QR is under development";
    }
}
