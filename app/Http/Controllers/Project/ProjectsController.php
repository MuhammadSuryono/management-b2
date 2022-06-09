<?php

namespace App\Http\Controllers\Project;

use App\Helpers\GuzzleRequester;
use Session;
use App\Http\Controllers\Controller;
use App\Customer2;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Import_excel;
use App\Imports\tmpRespondentsImport;
use App\Tmp_Respondent;
use Maatwebsite\Excel\Facades\Excel;
use App\Respondent;
use App\User_role;
use App\Kota;
use App\Pendidikan;
use App\SesFinal;
use App\Gender;
use App\Pekerjaan;
use App\Project_imported;
use App\IsValid;
use App\Vendor;
use App\Flag_rule;
use App\Kategori_fieldwork;
use App\Project_budget_integration;
use App\Project_budget_integration_tl;
use App\Quest_answer;
use App\Quest_code;
use App\Quest_option;
use App\Quest_question;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Mpdf\Tag\P;
use Requestby;

class ProjectsController extends Controller
{
    protected $guzzle;
    public function __construct()
    {
        $this->guzzle = new GuzzleRequester();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = DB::table('projects')->select('*')
            ->whereNotNull(['nama', 'kode_project'])
            ->get();

        $add_url = url('/projects/create');
        $customers = Customer2::all()->sortBy('nama');

        return view('projects.projects.index', compact('projects', 'customers', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectCommVoucher = DB::connection('mysql3')->table('comm_voucher')->select('*')
            ->groupBy('nomor_project')
            ->whereRaw('LENGTH(nomor_project) = 18')
            ->get();

        $projectSindikasi = DB::connection('mysql3')->table('data_sindikasi')->select('*')
            ->groupBy('nama_project')
            ->get();

        $vendors = Vendor::all();
        $fieldworks = Kategori_fieldwork::all()->sortBy('kategori_fieldwork');

        return view('projects.projects.createIwayRiway', compact('projectCommVoucher', 'projectSindikasi', 'vendors', 'fieldworks'));
    }

    public function ambilData()
    {
        $nomor_rfq = $_POST['nomor_rfq'];
        $table = $_POST['table'];
        if ($table == 'comm_voucher') {
            $data = DB::connection('mysql3')->table('data_rfq')->select('*')
                ->where('nomor_rfq', '=', $nomor_rfq)
                ->first();

            $dataCommVouc = DB::connection('mysql3')->table('comm_voucher')->select('*')
                ->where('nomor_project', '=', $nomor_rfq)
                ->first();

            $dataB2 = DB::table('projects')->select('*')
                ->where('nomor_rfq', '=', $nomor_rfq)
                ->get();

            $methodologyB2 = [];
            foreach ($dataB2 as $d2) {
                array_push($methodologyB2, $d2->methodology);
            }

            $arrCustomer = [];
            if (@unserialize($data->id_perusahaan)) {
                $customers = unserialize($data->id_customer);
                foreach ($customers as $c) {
                    $getCustomer = DB::connection('mysql3')->table('data_perusahaan')
                        ->select('*')
                        ->where('id_perusahaan', '=', $c)
                        ->first();
                    array_push($arrCustomer, $getCustomer->nama);
                }
            } else {
                $customers = $data->id_perusahaan;
                $getCustomer = DB::connection('mysql3')->table('data_perusahaan')
                    ->select('*')
                    ->where('id_perusahaan', '=', $customers)
                    ->first();
                array_push($arrCustomer, $getCustomer->nama);
            }

            $arrMethodology = [];
            $arrKetMethodology = [];
            if (@unserialize($data->id_methodology)) {
                $methodology = unserialize($data->id_methodology);
                foreach ($methodology as $m) {
                    $getMethodology = DB::connection('mysql3')->table('data_methodology')
                        ->select('*')
                        ->where('id_methodology', '=', $m)
                        ->first();
                    if (!in_array($getMethodology->methodology, $methodologyB2)) {
                        array_push($arrMethodology, $getMethodology->methodology);
                        array_push($arrKetMethodology, $getMethodology->keterangan);
                    }
                }
            } else {
                $methodology = $data->id_methodology;
                $getMethodology = DB::connection('mysql3')->table('data_methodology')
                    ->select('*')
                    ->where('id_methodology', '=', $methodology)
                    ->first();
                if (!in_array($getMethodology->methodology, $methodologyB2)) {
                    array_push($arrMethodology, $getMethodology->methodology);
                    array_push($arrKetMethodology, $getMethodology->keterangan);
                }
            }

            $data = [
                'data' => $data,
                'nama_internal' => $dataCommVouc->nama_project_internal,
                'customer' => $arrCustomer,
                'methodology' => $arrMethodology,
                'ket_methodology' => $arrKetMethodology
            ];
            echo json_encode($data);
        } else {
            $data = DB::connection('mysql3')->table('data_sindikasi')->select('*')
                ->where('nama_project', '=', $nomor_rfq)
                ->first();

            $dataB2 = DB::table('projects')->select('*')
                ->where('nama', '=', $nomor_rfq)
                ->get();

            $methodologyB2 = [];
            foreach ($dataB2 as $d2) {
                array_push($methodologyB2, $d2->methodology);
            }

            $arrMethodology = [];
            $arrKetMethodology = [];
            if (@unserialize($data->id_methodology)) {
                $methodology = unserialize($data->id_methodology);
                foreach ($methodology as $m) {
                    $getMethodology = DB::connection('mysql3')->table('data_methodology')
                        ->select('*')
                        ->where('id_methodology', '=', $m)
                        ->first();
                    if (!in_array($getMethodology->methodology, $methodologyB2)) {
                        array_push($arrMethodology, $getMethodology->methodology);
                        array_push($arrKetMethodology, $getMethodology->keterangan);
                    }
                }
            } else {
                $methodology = $data->id_methodology;
                $getMethodology = DB::connection('mysql3')->table('data_methodology')
                    ->select('*')
                    ->where('id_methodology', '=', $methodology)
                    ->first();
                if (!in_array($getMethodology->methodology, $methodologyB2)) {
                    array_push($arrMethodology, $getMethodology->methodology);
                    array_push($arrKetMethodology, $getMethodology->keterangan);
                }
            }

            $data = [
                'data' => $data,
                'customer' => [],
                'methodology' => $arrMethodology,
                'ket_methodology' => $arrKetMethodology
            ];
            echo json_encode($data);
        }
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

        $request->validate([
            'nomor_rfq' => 'required',
            'method' => 'required',
            // 'tgl_kickoff' => 'required',
            'tgl_akhir_kontrak' => 'required',
            // 'tgl_approve_kuesioner' => 'required',
            'kategori' => 'required'
        ]);

        DB::table('projects')
            ->insert([
                'nama' => $request->nama_project,
                'kode_project' => $request->kode_project,
                'nomor_rfq' => $request->nomor_rfq,
                'nama_customer' => $request->nama_client,
                'tgl_deal' => $request->tgl_deal,
                'tgl_kickoff' => $request->tgl_kickoff,
                'tgl_akhir_kontrak' => $request->tgl_akhir_kontrak,
                'tgl_approve_kuesioner' => $request->tgl_approve_kuesioner,
                'ket' => $request->ket,
                'kategori_fieldwork_id' => serialize($request->kategori),
                'vendor_korporasi' =>  $request->vendor_korporasi,
                'methodology' =>  $request->method,
                'user_id' => session('user_id'),
                'created_at' => $time,
                'updated_at' => $time,
            ]);

        $last_row = DB::table('projects')->latest()->first();

        $project_plan = DB::connection('mysql3')->table('project_plan')
            ->where('nomor_rfq', '=', $last_row->nomor_rfq)
            ->first();

        if ($project_plan) {

            $project_plan_data = DB::connection('mysql3')->table('project_plan_data')
                ->where('id_project_plan', '=', $project_plan->id_project_plan)
                ->get();

            foreach ($project_plan_data as $pdt) {
                DB::table('project_plans')
                    ->insert([
                        'project_id' => $last_row->id,
                        'urutan' => $pdt->urutan_proses,
                        'task_id' => $pdt->id_pp_master,
                        'date_start_target' => $pdt->date_start_target,
                        'date_finish_target' => $pdt->date_finish_target,
                        'date_start_real' => $pdt->date_start_real,
                        'date_finish_real' => $pdt->date_finish_real,
                        'n_target' => $pdt->n_target,
                        'n_real' => $pdt->n_real,
                        'ket' => $pdt->keterangan,
                        'user_id' => session('user_id'),
                        'created_at' => $time,
                        'updated_at' => $time
                    ]);
            }
        }
        // DB::table('projects')
        //     ->where('id', '=', $request->method)
        //     ->update([
        //         'nama' => $request->nama_project,
        //         'kode_project' => $request->kode_project,
        //         'tgl_kickoff' => $request->tgl_kickoff,
        //         'tgl_akhir_kontrak' => $request->tgl_akhir_kontrak,
        //         'tgl_approve_kuesioner' => $request->tgl_approve_kuesioner,
        //         'ket' => $request->ket,
        //         'kategori_fieldwork_id' => $request->kategori,
        //         'user_id' => session('user_id'),
        //         'created_at' => $time,
        //         'updated_at' => $time,
        //     ]);

        // INSERT KE BUDGET
        // $data = DB::connection('mysql')->table('users')->where('user_login', '=', session('user_login'))->first();
        // dd($data);
        // DB::connection('mysql2')
        //     ->table('pengajuan')
        //     ->insert([
        //         'jenis' => 'B2',
        //         'nama' => $request->nama_project,
        //         'tahun' => date('Y'),
        //         'pengaju' => $data->nama_user,
        //         'divisi' => $data->divisi,
        //         'status' => 'Belum Di Ajukan',
        //         'waktu' => $time,
        //         'kodeproject' => $request->kode_project,
        //         'is_laravel' => '1',
        //     ]);
        // AKHIR INSERT

        return redirect('/projects')->with('status', 'Data sudah disimpan');
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

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
            'updated_by_id' => session('user_id')
        ]);

        // INSERT DB BUDGET
        // $nama = new Budget();
        // $nama = $nama->getDivisi();
        // DB::connection('mysql2')->table('pengajuan')
        //     ->insert([
        //         'jenis' => 'B2',
        //         'nama' => $request->nama,
        //         'tahun' => date('Y'),
        //         'pengaju' => $nama->nama_user,
        //         'divisi' => $nama->divisi,
        //         'totalbudget' => '0',
        //         'totalbudgetnow' => '0',
        //         'status' => 'Belum Di Ajukan',
        //         'waktu' => date('Y-m-d H:i:s'),
        //         'kodeproject' => '',
        //         'is_laravel' => '1',
        //     ]);
        // AKHIR INSERT DB BUDGET

        return redirect('/projects')->with('status', 'Data sudah disimpan');
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
        session([
            'current_project_id' => $project->id,
            'current_project_nama' => $project->nama
        ]);

        $worksheet = Quest_code::where('project_id', $project->id)->get();
        $tmp_respondent = DB::table('tmp_respondents')->whereNull('intvdate')->orWhereNull('vstart')->orWhereNull('vend')->orWhereNull('duration')->orWhereNull('upload')->get();

        $projectName = sprintf('%s|%s', $project->nama, $project->nama . ' - ' . $project->methodology);
        $res = $this->guzzle->request('GET', sprintf('api/pengajuan/read?name=%s', $projectName));
        $budget = null;

        if ($res->getStatusCode() == 200) {
            $budget = $res->getBody()->data;
        }

        if ($budget)
            $unlock_budget = 1;
        else
            $unlock_budget = 0;

        return view('projects.projects.edit', compact('project', 'worksheet', 'tmp_respondent', 'unlock_budget'));
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
        // //Validation
        // $validatedData = $request->validate([
        //     'nama' => 'required|unique:projects,nama,'. $project->id . ',id|max:50',
        //     'customer_id' => 'required',
        //     'project_date' => 'required',
        //     'date_start_target' => 'required',
        //     'date_finish_target' => 'required',
        //     'ket' => 'required',
        // ]);

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
                'batas_waktu_do' => $request->batas_waktu,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by_id' => session('user_id')
            ]);

        return redirect('/projects')->with('status', 'Data sudah diubah');
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
        Project::destroy($id);
        return redirect('/projects')->with('status', 'Data sudah dihapus');
    }

    public function scan_qr()
    {
        return "Scan QR is under development";
    }

    public function upload(Request $request)
    {
        if ($request->button == 'respondent') {
            for ($i = 0; $i < count($_FILES["file"]["name"]); $i++) {
                if (Import_excel::all()->count() > 0) {
                    $ketemu = Import_excel::where('excel_file',  $request->file('file')[$i]->getClientOriginalName())->get()->count();
                    if ($ketemu > 0)
                        return redirect('/projects/' . $request->id . '/edit')->with('status-fail', 'File excel pernah diload');
                }
                DB::table('tmp_respondents')->truncate();
                Excel::import(new tmpRespondentsImport, $request->file[$i]);
                $count = Tmp_Respondent::whereNull('intvdate')->orWhereNull('vstart')->orWhereNull('vend')->orWhereNull('duration')->orWhereNull('upload')->count();
                if ($count) {
                    return redirect('/projects/' . $request->id . '/edit')->with('status-fail', 'Upload gagal, Terdapat kesalahan format pada data yang di upload, klik "Check History Upload" untuk melihat detail.');
                }
                Import_excel::create([
                    'excel_file' => str_replace(' ', '_', $request->file('file')[$i]->getClientOriginalName()),
                    'jumlah_record' => tmp_respondent::all()->count(),
                    'user_id' => session('user_id'),
                ]);
                $xid = Import_excel::where('excel_file', str_replace(' ', '_', $request->file('file')[$i]->getClientOriginalName()))->first()->id;

                $c1 =  DB::table('tmp_respondents')->select('*')->get();

                $checkProjectImported = Project_imported::where('project_imported',  $c1[0]->project)->get()->count();
                if ($checkProjectImported == 0)
                    DB::table('project_importeds')->insert([
                        'project_imported' => $c1[0]->project,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                // Pengecekan Data double untuk nomor handphone dan sbjnum
                $arrPhone = [];
                $arrSbjnum = [];
                foreach ($c1 as $record) {
                    if ($record->project != session('current_project_nama')) {
                        Import_excel::orderBy('id', 'desc')->limit(1)->delete();
                        return redirect('/projects/' . $request->id . '/edit')->with('status-fail', 'Upload gagal, Terdapat nama project yang berbeda di dalam file.');
                    }

                    if (!in_array($record->mobilephone, $arrPhone) &&  !in_array($record->sbjnum, $arrSbjnum)) {
                        array_push($arrSbjnum, $record->sbjnum);
                        array_push($arrPhone, $record->mobilephone);
                    } else {
                        Import_excel::orderBy('id', 'desc')->limit(1)->delete();
                        return redirect('/projects/' . $request->id . '/edit')->with('status-fail', 'Upload gagal, Terdapat nomor telfon atau sbjnum yang sama dalam file.');
                    }

                    $checkMobilephoneRespondent = Respondent::where('mobilephone', $record->mobilephone)->count();
                    $checkSbjnumRespondent = Respondent::where('sbjnum', $record->sbjnum)->count();
                    if ($checkMobilephoneRespondent) {
                        Import_excel::orderBy('id', 'desc')->limit(1)->delete();
                        return redirect('/projects/' . $request->id . '/edit')->with('status-fail', 'Upload gagal, Nomor telfon ' . $record->mobilephone . ' sudah ada di database.');
                    }

                    if ($checkSbjnumRespondent) {
                        Import_excel::orderBy('id', 'desc')->limit(1)->delete();
                        return redirect('/projects/' . $request->id . '/edit')->with('status-fail', 'Upload gagal, sbjnum ' . $record->sbjnum . ' sudah ada di database.');
                    }
                }
                foreach ($c1 as $record) {
                    $idImportedProject = Project_imported::where('project_imported', '=', $record->project)->first();
                    $idProject = null;
                    if ($record->project == session('current_project_nama')) {
                        $idProject = Project::where('nama', '=', $record->project)->first();
                    }

                    if (!is_null($idImportedProject) && !is_null($idProject)) {
                        // $getQuestCode = DB::table('quest_codes')->where('project_id', $idProject->id)->where('nama', $record->worksheet)->first();

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
                            'worksheet' => $record->worksheet,
                            'kategori_honor' => $record->kategori_honor,
                            'kategori_gift' => $record->kategori_gift,
                            // 'status_pembayaran_id' => 1,
                            'status_qc_id' => 1,
                            // 'kode_bank' => $record->kode_bank,
                            // 'nomor_rekening' => $record->nomor_rekening,
                            // 'pemilik_rekening' => $record->pemilik_rekening,
                            'tanggal_upload' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                        $getLast =  DB::table('respondents')->latest('id')->first();
                        DB::table('respondent_gifts')->insert([
                            'respondent_id' => $getLast->id,
                            'mobilephone' => $record->mobilephone_gift,
                            'e_wallet_kode' => $record->e_wallet_code,
                            'status_kepemilikan_id' => $record->status_kepemilikan_mobilephone,
                            'pemilik_mobilephone' => $record->nama_pemilik_mobilephone,
                            'kode_bank' => $record->kode_bank,
                            'nomor_rekening' => $record->nomor_rekening,
                            'pemilik_rekening' => $record->pemilik_rekening,
                            'status_pembayaran_id' => 1,
                            'created_at' => Carbon::now(),
                        ]);
                    }
                }

                DB::statement('call import_tmp_respondents(' . $xid .   ')');

                // $countTypes = DB::table('tmp_respondents')->select('project')->groupBy('project')->get();
                // if (count($countTypes) == 1) {
                //     if ($countTypes[0]->project == session('current_project_nama')) {
                //         $tot_rec = Respondent::where('import_excel_id', $xid)->count();
                //         Import_excel::where('id', $xid)->update(['jumlah_record' => $tot_rec]);
                //     } else {
                //         return redirect('/projects/' . $request->id . '/edit')->with('status-fail', 'Upload gagal, Nama project berbeda.');
                //     }
                // } else {
                //     return redirect('/projects/' . $request->id . '/edit')->with('status-fail', 'Upload gagal, Terdapat lebih dari satu nama project di dalam file.');
                // }
            }
        }
        // dd('here');

        $arrName = [];
        if ($request->file) {
            for ($i = 0; $i < count($_FILES["file"]["name"]); $i++) {
                $extension = pathinfo($_FILES["file"]["name"][$i], PATHINFO_EXTENSION);
                if ($request->button == 'kuesioner' || $request->button == 'tl') {
                    $nama_gambar = $request->button . '-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . $i . "." . $extension;
                } else {
                    $nama_gambar = $_FILES["file"]["name"][$i];
                    $nama_gambar = str_replace(' ', '_', $nama_gambar);
                }
                $target_file =  $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;
                array_push($arrName, strval($nama_gambar));
                move_uploaded_file($_FILES["file"]["tmp_name"][$i], $target_file);
            }

            $queryProject = Project::where('id', session('current_project_id'))->first();
            if ($request->button == 'tl') {
                $file = (unserialize($queryProject['file_team_leader'])) ? unserialize($queryProject['file_team_leader']) : [];
                foreach ($arrName as $an) {
                    array_push($file, $an);
                }

                Project::where('id', $request->id)
                    ->update([
                        'file_team_leader' => serialize($file)
                    ]);
            } else if ($request->button == 'kuesioner') {
                $file = (unserialize($queryProject['file_kuesioner'])) ? unserialize($queryProject['file_kuesioner']) : [];
                foreach ($arrName as $an) {
                    array_push($file, $an);
                }

                Project::where('id', $request->id)
                    ->update([
                        'file_kuesioner' => serialize($file)
                    ]);
            } else if ($request->button == 'respondent') {
                $file = (unserialize($queryProject['file_respondent'])) ? unserialize($queryProject['file_respondent']) : [];
                foreach ($arrName as $an) {
                    array_push($file, $an);
                }

                Project::where('id', $request->id)
                    ->update([
                        'file_respondent' => serialize($file)
                    ]);
            }
            return redirect('/projects/' . $request->id . '/edit')->with('status', 'Upload Sukses');
        } else {
            return redirect('/projects/' . $request->id . '/edit')->with('status-fail', 'Upload gagal');
        }
    }


    public function view(Request $request)
    {
        $file = $request->project;
        return response()->file($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $file);
    }

    public function viewRespondents(Request $request)
    {
        $kotas = Kota::all()->sortBy('kota');
        $pendidikans = Pendidikan::all()->sortBy('pendidikan');
        $ses_finals = SesFinal::all();
        $genders = Gender::all();
        $pekerjaans = Pekerjaan::all()->sortBy('pekerjaan');
        $project_importeds = Project_imported::all()->sortBy('project_imported');
        $is_valids = Isvalid::all();

        $user_role = User_role::selectRaw('distinct roles.role')
            ->join('roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_roles.user_id', [session('user_id')])
            ->where('roles.role', 'Administrators')
            ->get();

        if (session('link_from') == 'saving') {
            $params = session('last_resp_param');
        } else {
            $params = $request->except('_token');
            Session::put('last_resp_param', $params);
        }
        session(['link_from' => 'menu']);

        $namaFile =  request()->segment(count(request()->segments()));

        $idExcel = Import_excel::where('excel_file', $namaFile)->first()->id;

        $respondents = Respondent::where('import_excel_id', '=', $idExcel)->get();

        $project = Project::where('id', $respondents[0]->project_id)->first();
        $rules = Flag_rule::where('project_id', $project->id)->first();

        return view('projects.projects.view_respondent', compact(
            'respondents',
            'kotas',
            'pendidikans',
            'ses_finals',
            'genders',
            'pekerjaans',
            'project_importeds',
            'is_valids',
            'user_role'
        ));
    }

    public function setFlagRules(Request $request)
    {
        $id = $request->id;
        $flag_rules = Flag_rule::where('project_id', $id)->first();
        return view('projects.projects.set_flag_rules', compact('id', 'flag_rules'));
    }

    public function storeFlagRules(Request $request)
    {
        $idProject = $request->id;
        $checkData = Flag_rule::where('project_id', $idProject)->count();
        if ($checkData) {
            Flag_rule::where('project_id', $idProject)
                ->update([
                    'project_id' => $idProject,
                    'less_than_status' => $request->less_than_status,
                    'less_than_minute' => $request->less_than_minute,
                    'more_than_status' => $request->more_than_status,
                    'more_than_minute' => $request->more_than_minute,
                    'after_status' => $request->after_status,
                    'after_time' => $request->after_time,
                    'before_status' => $request->before_status,
                    'before_time' => $request->before_time,
                    'longlat_status' => $request->longlat_status,
                    'rekaman_status' => $request->rekaman_status,
                    'upload_status' => $request->upload_status,
                    'created_at' => time()
                ]);
        } else {
            Flag_rule::create([
                'project_id' => $idProject,
                'less_than_status' => $request->less_than_status,
                'less_than_minute' => $request->less_than_minute,
                'more_than_status' => $request->more_than_status,
                'more_than_minute' => $request->more_than_minute,
                'after_status' => $request->after_status,
                'after_time' => $request->after_time,
                'before_status' => $request->before_status,
                'before_time' => $request->before_time,
                'longlat_status' => $request->longlat_status,
                'rekaman_status' => $request->rekaman_status,
                'upload_status' => $request->upload_status,
            ]);
        }

        return redirect('/projects/' . $request->id . '/edit')->with('status', 'Flag Rules Dibuat');
    }

    public function getItemBudget(Request $request)
    {
        $getId = DB::connection('mysql2')->table('pengajuan')
            ->select('*')
            ->where('noid', '=', $request->id)
            ->first();

        $result = DB::connection('mysql2')->table('selesai')
            ->select('*')
            ->where('waktu', '=', $getId->waktu)
            ->orderBy('rincian')
            ->get();
        echo json_encode($result);
    }

    public function budgetIntegration(Request $request)
    {
        $id = $request->id;
        $project = Project::where('id', $id)->first();
       $projectName = sprintf('%s|%s', $project->nama . ' - ' . $project->methodology, $project->nama);
        $res = $this->guzzle->request('GET', sprintf('api/pengajuan/read?name=%s', $projectName));
        $itemBudget = [];
        $budget = null;

        if ($res->getStatusCode() == 200) {
            $itemBudget = $res->getBody()->data->items;
            $budget = $res->getBody()->data;
        }
        $integration_settings = Project_budget_integration::where('project_id', $id)->first();

        if (@unserialize($integration_settings->pembayaran_interviewer))
            $pembayaran_interviewer = unserialize($integration_settings->pembayaran_interviewer);
        else
            $pembayaran_interviewer = [];

        $jabatan = DB::select('SELECT pk.kota_id AS id_kota,
             pk.id AS project_kota_id, pj.id AS project_jabatan_id, j.jabatan, pj.jabatan_id
        FROM  project_kotas pk
            LEFT JOIN project_jabatans pj ON pk.id = pj.project_kota_id
            LEFT JOIN jabatans j ON pj.jabatan_id = j.id
        WHERE pk.project_id = ' . $id .
            ' GROUP BY jabatan');
        return view('projects.projects.budget_integration', compact('id', 'budget', 'itemBudget', 'integration_settings', 'pembayaran_interviewer', 'jabatan'));
    }

    public function setBudgetIntegration(Request $request)
    {
        // dd($request);
        $idProject = $request->id;
        $checkData = Project_budget_integration::where('project_id', $idProject)->count();
        if ($checkData) {
            Project_budget_integration::where('project_id', $idProject)
                ->update([
                    'project_id' => $idProject,
                    'pembayaran_gift' => $request->pembayaran_gift,
                    'item_budget_id_pembayaran_gift' => $request->item_budget_id_pembayaran_gift,
                    'pembayaran_interviewer' => serialize($request->pembayaran_interviewer),
                    'item_budget_id_pembayaran_interviewer' => $request->item_budget_id_pembayaran_interviewer,
                    'pembayaran_tl' => $request->pembayaran_tl,
                    'item_budget_id_pembayaran_tl' => $request->item_budget_id_pembayaran_tl,
                ]);
        } else {
            Project_budget_integration::create([
                'project_id' => $idProject,
                'pembayaran_gift' => $request->pembayaran_gift,
                'item_budget_id_pembayaran_gift' => $request->item_budget_id_pembayaran_gift,
                'pembayaran_interviewer' => serialize($request->pembayaran_interviewer),
                'item_budget_id_pembayaran_interviewer' => $request->item_budget_id_pembayaran_interviewer,
                'pembayaran_tl' => $request->pembayaran_tl,
                'item_budget_id_pembayaran_tl' => $request->item_budget_id_pembayaran_tl,
                'created_at' => time()
            ]);
        }

        $jabatan = DB::select('SELECT pk.kota_id AS id_kota,
        pk.id AS project_kota_id, pj.id AS project_jabatan_id, j.jabatan, pj.jabatan_id
   FROM  project_kotas pk
       LEFT JOIN project_jabatans pj ON pk.id = pj.project_kota_id
       LEFT JOIN jabatans j ON pj.jabatan_id = j.id
   WHERE pk.project_id = ' . $idProject .
            ' GROUP BY jabatan');

        // var_dump($request->pembayaran_9);
        foreach ($jabatan as $item) {
            if (isset($request->{"pembayaran_" . "$item->jabatan_id"})) {
                $checkData = Project_budget_integration_tl::where('project_id', $idProject)->where('jabatan_id', $item->jabatan_id)->count();
                if ($checkData) {
                    Project_budget_integration_tl::where('project_id', $idProject)->where('jabatan_id', $item->jabatan_id)->update([
                        'pembayaran' => serialize($request->{"pembayaran_" . "$item->jabatan_id"}),
                        'item_budget_id' => $request->{"item_budget_id_pembayaran_" . "$item->jabatan_id"}
                    ]);
                } else {
                    Project_budget_integration_tl::create([
                        'project_id' => $idProject,
                        'jabatan_id' => $item->jabatan_id,
                        'pembayaran' => serialize($request->{"pembayaran_" . "$item->jabatan_id"}),
                        'item_budget_id' => $request->{"item_budget_id_pembayaran_" . "$item->jabatan_id"}
                    ]);
                }
            }
        }
        // dd($request);

        return redirect('/projects/' . $request->id . '/edit')->with('status', 'Pengaturan Integrasi berhasil disimpan');
    }
}
