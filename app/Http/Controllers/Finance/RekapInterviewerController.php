<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Project_kota;
use App\Project_team;
use App\User;
use App\Team;
use App\User_role;
use App\Respondent;
use App\Kota;
use App\Pendidikan;
use App\SesFinal;
use App\Gender;
use App\Pekerjaan;
use App\Project_imported;
use App\IsValid;
use App\Project;
use App\Status_qc;
use App\Status_callback;
use App\Team_jabatan;
use App\Flag_rule;
use App\Data_qc;
use App\Divisi;
use App\Pembayaran_interviewer;
use App\Project_budget_integration;
use App\Project_honor;
use App\Project_honor_do;
use App\Quest_code;
use App\Respondent_btf;
use App\Status_pengecekan;
use App\Team_payment_marking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapInterviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $honor_category = [];
        $honor_do_category = [];
        $kotas = Project_kota::join('kotas', 'project_kotas.kota_id', '=', 'kotas.id')->select('kotas.*')
            ->when(isset($request->project_id) && $request->project_id != 'all', function ($query) use ($request) {
                return $query->where('project_id', $request->project_id);
            })->orderBy('kotas.kota', 'ASC')->distinct()->get();
        if ($request->project_id != 'all' && $request->project_id) {
            $checkBudgetIntegration = Project_budget_integration::where('project_id', $request->project_id)->whereNotNull('item_budget_id_pembayaran_interviewer')->first();
            if (!isset($checkBudgetIntegration)) {
                return redirect(url()->previous())->with('status-fail', 'Item budget belum ada atau pembayaran dilakukan external');
            }

            if (@unserialize($checkBudgetIntegration->pembayaran_interviewer))
                $pembayaran_interviewer = unserialize($checkBudgetIntegration->pembayaran_interviewer);
            else
                $pembayaran_interviewer = [];

            if (in_array('internal', $pembayaran_interviewer) && in_array('external', $pembayaran_interviewer)) {
                $teamPaymentMarking = Team_payment_marking::with(['team'])
                    ->leftJoin('project_teams', 'project_teams.id', '=', 'team_payment_markings.project_team_id')
                    ->leftJoin('project_kotas', 'project_kotas.id', '=', 'project_teams.project_kota_id')
                    ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                        return $query->where('project_kotas.kota_id', '=', $request->kota_id);
                    })
                    ->whereNotIn('team_payment_markings.team_id', function ($query) {
                        $query->select('team_id')->from('pembayaran_interviewers');
                    })
                    ->where('team_payment_markings.project_id', $request->project_id)
                    ->where('posisi', 'Interviewer')
                    ->get();

                $teams = [];
                if ($teamPaymentMarking != null) {
                    foreach ($teamPaymentMarking as $team) {
                        $team->team->is_can_marking = '';
                        $team->team->bg_color = '';
                        $teams[] = $team->team;
                    }
                }
                dd($teams);

            } else if (in_array('internal', $pembayaran_interviewer)) {
                $respondents = Respondent::where('project_id', '=', $request->project_id)
                    ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                        return $query->where('kota_id', '=', $request->kota_id);
                    })
                    ->get();
                $dbDigitalisasiMarketing = DB::connection('mysql3');

                $teams = [];
                $checkId = [];
                foreach ($respondents as $r) {
                    if ($r->srvyr) {
                        $pwtCode = substr($r->srvyr, 3, 6);
                        $pwtCode = (int)$pwtCode;

                        $cityCode = substr($r->srvyr, 0, 3);
                        $cityCode = (int)$cityCode;

                        $projectTeam = Project_team::with(['team','projectKota' => function($q) use ($cityCode) {
                            $q->with(['kota']);
                        }])
                            ->where('team_leader', '!=', 0)
                            ->where('team_id', $pwtCode)->where("project_kota_id", $cityCode)->first();

                        if ($projectTeam != null) {
                            $leader = Project_team::where("project_kota_id", $cityCode)->where('team_leader', $projectTeam->team_leader)->first();
                            if (isset($projectTeam->team) && $leader->type_tl != "borongan") {
                                $projectKota = $projectTeam->projectKota;
                                $pwt = $projectTeam->team;
                                $isAlreadyPayment = Pembayaran_interviewer::where('project_id', $request->project_id)->where('team_id', $pwt->id)->first();
                                if (!$isAlreadyPayment) {
                                    if (!in_array($pwt->id, $checkId)) {
                                        $bank = $dbDigitalisasiMarketing->table('bank')->where('kode', '=', $pwt->kode_bank)->first();
                                        $pwt->type_tl = $leader->type_tl;
                                        $pwt->project_kota = $projectKota->kota->kota;
                                        $pwt->bank = $bank != null ? $bank->nama : "-";
                                        $pwt->project_team_id = $projectTeam->id;

                                        $bgColor = "";
                                        $isCanMarking = true;
                                        if ($pwt->bank == "-" && $pwt->nomor_rekening == "") {
                                            $isCanMarking = false;
                                            $bgColor = "bg-danger";
                                        }

                                        $pwt->is_can_marking = $isCanMarking;
                                        $pwt->bg_color = $bgColor;
                                        array_push($teams, $pwt);
                                        array_push($checkId, $pwt->id);
                                    }
                                }
                            }
                        }
                    }
                }
            }

        } else {
            $teams = [];
            // dd(count($teams));
            $kotas = Kota::all()->sortBy('kota');
        }

        $honor_category = Project_honor::join('project_kotas', 'project_kotas.id', '=', 'project_honors.project_kota_id')
            ->where('project_kotas.project_id', '=', $request->project_id)
            ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                return $query->where('kota_id', '=', $request->kota_id);
            })
            ->get();

        $honor_do_category = Project_honor_do::join('project_kotas', 'project_kotas.id', '=', 'project_honor_dos.project_kota_id')
            ->where('project_kotas.project_id', '=', $request->project_id)
            ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                return $query->where('kota_id', '=', $request->kota_id);
            })
            ->get();
        $projects = Project::all()->sortBy('nama');
        $pendidikans = Pendidikan::all()->sortBy('pendidikan');
        $ses_finals = SesFinal::all();
        $genders = Gender::all();
        // $teams = Team::all();
        $pekerjaans = Pekerjaan::all()->sortBy('pekerjaan');
        $is_valids = Isvalid::all();

        $add_url = url('/menus/create');
        return view('finances.rekap_interviewer.index', compact('teams', 'add_url', 'projects', 'kotas', 'pendidikans', 'ses_finals', 'genders', 'teams', 'pekerjaans', 'is_valids', 'honor_category', 'honor_do_category'));
    }

    public function indexRtp(Request $request)
    {
        // dd('here');
        $honor_category = [];
        $honor_do_category = [];
        if ($request->project_id != 'all' && $request->project_id) {
            $honor_category = Project_honor::join('project_kotas', 'project_kotas.id', '=', 'project_honors.project_kota_id')
                ->where('project_kotas.project_id', '=', $request->project_id)
                ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                    return $query->where('kota_id', '=', $request->kota_id);
                })
                ->get();

            $honor_do_category = Project_honor_do::join('project_kotas', 'project_kotas.id', '=', 'project_honor_dos.project_kota_id')
                ->where('project_kotas.project_id', '=', $request->project_id)
                ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                    return $query->where('kota_id', '=', $request->kota_id);
                })
                ->get();
            $teams = Pembayaran_interviewer::join('teams', 'teams.id', '=', 'pembayaran_interviewers.team_id')
                ->where('pembayaran_interviewers.project_id', '=', $request->project_id)
                ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                    return $query->where('kota_id', '=', $request->kota_id);
                })
                ->when(isset($request->status_pembayaran_id) && trim($request->status_pembayaran_id) !== 'all', function ($query2) use ($request) {
                    $query2->where('pembayaran_interviewers.status_pembayaran_id', '=', trim($request->status_pembayaran_id));
                })
                ->get();


            $kotas = Pembayaran_interviewer::join('teams', 'teams.id', '=', 'pembayaran_interviewers.team_id')->join('kotas', 'teams.kota_id', '=', 'kotas.id')->select('kotas.*')->where('project_id', $request->project_id)->orderBy('kotas.kota', 'ASC')->distinct()->get();
        } else {
            $teams = [];
            $kotas = Kota::all()->sortBy('kota');
        }

        $projects = Project::all()->sortBy('nama');
        $pendidikans = Pendidikan::all()->sortBy('pendidikan');
        $ses_finals = SesFinal::all();
        $genders = Gender::all();
        $pekerjaans = Pekerjaan::all()->sortBy('pekerjaan');
        $is_valids = Isvalid::all();

        // $menus = Menu::all();
        $add_url = url('/menus/create');
        // $kotas = Kota::all()->sortBy('kota');
        return view('finances.rekap_interviewer.index_rtp', compact('teams', 'add_url', 'projects', 'kotas', 'pendidikans', 'ses_finals', 'genders', 'teams', 'pekerjaans', 'is_valids', 'honor_category', 'honor_do_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu = Menu::first();
        $title = 'Tambah Menu';
        $create_edit = 'create';
        $action_url = url('/menus');
        $include_form = 'otentikasis.menus.form_menu';
        return view('crud.open_record', compact('menu', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'menu' =>  'required|unique:menus|max:60',
        ]);

        Menu::create($request->all());
        return redirect('/menus')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $title = 'Edit Menu';
        $create_edit = 'edit';
        $action_url = url('/menus') . '/' . $menu->id;
        $include_form = 'otentikasis.menus.form_menu';
        return view('crud.open_record', compact('menu', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'menu' => 'required|unique:menus,menu,' . $menu->id . ',id|max:60',
        ]);
        Menu::where('id', $menu->id)->update([
            'menu' => $request->menu,
        ]);
        return redirect('/menus')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }

    public function delete($id)
    {
        Menu::destroy($id);
        return redirect('/menus')->with('status', 'Data sudah dihapus');
    }

    public function changeStatus(Request $request)
    {
        // var_dump($_POST['id']);
        // dd($request);
        // $request->project_id = 33;
        $nextStatus = $request->nextStatus;
        // dd('here');
        $divisi = Divisi::where("id", session('divisi_id'))->first();
        $project = Project::where('id', $request->project_id)->first();
        $itemBpu = Project_budget_integration::select('item_budget_id_pembayaran_interviewer')->where('project_id', $project->id)->first();

        $budget =  DB::connection('mysql2')->table('pengajuan')->select('*')->where('nama', $project->nama)->first();
        if (isset($budget)) {
            $term = DB::connection('mysql2')->table('bpu')->where('no', $itemBpu->item_budget_id_pembayaran_interviewer)->where('waktu', $budget->waktu)->max('term');

            $selesai = DB::connection('mysql2')->table('selesai')->where('no', $itemBpu->item_budget_id_pembayaran_interviewer)->where('waktu', $budget->waktu)->first();

            $user = User::where('id', session('user_id'))->first();

            $userBudget = DB::connection('mysql2')->table('tb_user')->where('id_user', $user->id_user_budget)->first();

            $get_kas = DB::connection('mysql5')->table('kas')->select('*')->where('label_kas', 'Kas Project')->first();

            $get_jenis_pembayaran = DB::connection('mysql6')->table('jenis_pembayaran')->select('*')->where('jenispembayaran', $selesai->status)->first();

            if ($nextStatus == 2) {
                for ($i = 0; $i < count($request->id); $i++) {

                    $team = Team::where('id', $request->id[$i])->first();
                    $bank = DB::connection('mysql3')->table('bank')->select('*')->where('kode', $team->kode_bank)->first();
                    // dd($bank);

                    $total = "total-" . $request->id[$i];

                    if ($get_jenis_pembayaran) {
                        if ($request->total > $get_jenis_pembayaran->max_transfer) {
                            $metode_pembayaran = 'MRI Kas';
                        } else {
                            $metode_pembayaran = 'MRI PAL';
                        }
                    }

                    $insertBpu = DB::connection('mysql2')->table('bpu')->insert([
                        'no' => $itemBpu->item_budget_id_pembayaran_interviewer,
                        'jumlah' => $request->$total,
                        'namapenerima' => $team->nama,
                        'norek' => $team->nomor_rekening,
                        'namabank' => isset($bank->swift_code) ? $bank->swift_code : 'Tidak ada',
                        'emailpenerima' => isset($team->email) ? $team->email : 'Tidak ada',
                        'metode_pembayaran' => $metode_pembayaran,
                        'status' => 'Belum Di Bayar',
                        'persetujuan' => 'Belum Disetujui',
                        'term' => $term + 1,
                        'status_pengajuan_bpu' => 0,
                        'pengaju' => $userBudget->nama_user,
                        'divisi' => $userBudget->divisi,
                        'waktu' => $budget->waktu,
                        'from_another_app' => 1,
                        'created_at' => date('Y-m-d')
                    ]);

                    $noid = DB::connection('mysql2')->table('bpu')->select('noid')->orderBy('noid', 'desc')->first();

                    $update = Pembayaran_interviewer::insert([
                        'project_id' => $request->project_id,
                        'team_id' => $request->id[$i],
                        'total' => $request->$total,
                        'status_pembayaran_id' => $nextStatus,
                        'bpu_term' => $term + 1,
                        'bpu_noid' => $noid->noid,
                        'metode_pembayaran' => $metode_pembayaran,
                        'tanggal_pengajuan' => date('Y-m-d'),
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    $date = date('my');
                    $count = DB::connection('mysql4')->table('data_transfer')->select('transfer_req_id')->where('transfer_req_id', 'like', $date . '%')->orderBy('transfer_req_id', 'desc')->first();
                    if ($count) {
                        $count = (int)substr($count->transfer_req_id, -4);
                    } else {
                        $count = 0;
                    }
                    $formatId = $date . sprintf('%04d', $count + 1);

                    if ($bank->swift_code == "CENAIDJA") {
                        $biayaTrf = 0;
                    } else {
                        $biayaTrf = 2900;
                    }

                    if ($metode_pembayaran = 'MRI PAL') {
                        $insertTrasfer =  DB::connection('mysql4')->table('data_transfer')->insert([
                            'transfer_req_id' => $formatId,
                            'transfer_type' => 3,
                            'jenis_pembayaran_id' => 1,
                            'keterangan' => $selesai->status,
                            'waktu_request' =>  $budget->waktu,
                            'norek' => $team->nomor_rekening,
                            'pemilik_rekening' => $team->nama,
                            'bank' => $bank->nama,
                            'kode_bank' => $bank->swift_code,
                            'berita_transfer' => 'Pembayaran Honor',
                            'jumlah' => $request->$total,
                            'terotorisasi' => 2,
                            'hasil_transfer' => 1,
                            'ket_transfer' => 'Antri',
                            'nm_pembuat' => session('nama'),
                            'nm_validasi' => '',
                            'nm_manual' => '',
                            'jenis_project' => $budget->jenis,
                            'nm_project' => $budget->nama,
                            'noid_bpu' => $noid->noid,
                            'biaya_trf' => $biayaTrf,
                            'email_pemilik_rekening' => isset($team->email) ? $team->email : '',
                            'jadwal_transfer' => date('Y-m-d H:i:s'),
                            'rekening_sumber' => $get_kas->rekening
                        ]);
                    }
                    // dd('here');
                }
            } else if ($nextStatus == 3) {
                $arrId = explode(',', $request->id);
                $arrTotal = explode(',', $request->total);

                for ($i = 0; $i < count($arrId); $i++) {
                    $team = Team::where('id', $arrId[$i])->first();

                    $pembayaranInterviewer = Pembayaran_interviewer::where('project_id', $request->project_id)->where('team_id', $team->id)->first();
                    $update = Pembayaran_interviewer::where('id', $pembayaranInterviewer->id)->update([
                        'status_pembayaran_id' => $nextStatus,
                        'keterangan_pembayaran' => $request->ket_pembayaran,
                        'tanggal_pembayaran' => date('Y-m-d'),
                    ]);

                    $insertBpu = DB::connection('mysql2')->table('bpu')->where('noid', $pembayaranInterviewer->bpu_noid)->update([
                        'jumlahbayar' => $arrTotal[$i],
                        'persetujuan' => 'Disetujui oleh sistem',
                        'status' => 'Telah Di Bayar',
                    ]);
                }
            } else if ($nextStatus == 4) {
                $arrId = explode(',', $request->id);
                $arrTotal = explode(',', $request->total);

                for ($i = 0; $i < count($arrId); $i++) {
                    $team = Team::where('id', $arrId[$i])->first();
                    $pembayaranInterviewer = Pembayaran_interviewer::where('project_id', $request->project_id)->where('team_id', $team->id)->first();
                    $update = Pembayaran_interviewer::where('id', $pembayaranInterviewer->id)->update([
                        'status_pembayaran_id' => $nextStatus,
                        'keterangan_pembayaran' => $request->ket_pembayaran
                    ]);
                }
            }
        } else {
            return redirect(url()->previous())->with('status-fail', 'Tidak ada budget terdeteksi');
        }

        if (isset($update)) {
            return redirect(url()->previous())->with('status', 'Status berhasil diubah');
        } else {
            return redirect(url()->previous())->with('status-fail', 'Status gagal diubah');
        }
    }

    public function marking(Request $request)
    {
        $respondents = Respondent::where('project_id', '=', $request->id)
            ->get();
        $dbDigitalisasiMarketing = DB::connection('mysql3');

        $teams = [];
        $checkId = [];

        foreach ($respondents as $r) {
            if ($r->srvyr) {
                $pwtCode = substr($r->srvyr, 3, 6);
                $pwtCode = (int)$pwtCode;

                $cityCode = $r->kota_id;
                $projectTeam = Project_team::with(['team','projectKota' => function($q) use ($cityCode) {
                    $q->with(['kota']);
                }])
                    ->where('team_leader', '!=', 0)
                    ->where('team_id', $pwtCode)->where("project_kota_id", $cityCode)->first();

                if ($projectTeam != null) {
                    $leader = Project_team::where("project_kota_id", $cityCode)->where('team_leader', $projectTeam->team_leader)->first();
                    if (isset($projectTeam->team) && $leader->type_tl != "borongan") {
                        $projectKota = $projectTeam->projectKota;
                        $pwt = $projectTeam->team;
                        if (!in_array($pwt->id, $checkId)) {
                            $bank = $dbDigitalisasiMarketing->table('bank')->where('kode', '=', $pwt->kode_bank)->first();
                            $pwt->type_tl = $leader->type_tl;
                            $pwt->project_kota = $projectKota->kota->kota;
                            $pwt->bank = $bank != null ? $bank->nama : "-";
                            $pwt->project_team_id = $projectTeam->id;

                            $bgColor = "";
                            $isCanMarking = true;
                            if ($pwt->bank == "-" && $pwt->nomor_rekening == "") {
                                $isCanMarking = false;
                                $bgColor = "bg-danger";
                            }

                            $pwt->is_can_marking = $isCanMarking;
                            $pwt->bg_color = $bgColor;
                            array_push($teams, $pwt);
                            array_push($checkId, $pwt->id);
                        }
                    }
                }
            }
        }

        // $menus = Menu::all();
        $add_url = url('/menus/create');
        // $kotas = Kota::all()->sortBy('kota');
        return view('finances.rekap_interviewer.marking', compact('teams'));
    }

    public function updateMarking(Request $request)
    {
        if ($request->status == 'mark') {
            $checkData = Team_payment_marking::where('project_id', $request->project_id)->where('team_id', $request->id)->where('posisi', 'Interviewer')->count();
            if (!$checkData) {
                $update = Team_payment_marking::insert([
                    'project_id' => $request->project_id,
                    'team_id' => $request->id,
                    'posisi' => 'Interviewer',
                    'project_team_id' => $request->project_team_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        } else if ($request->status == 'unmark') {
            $update = Team_payment_marking::where('project_id', $request->project_id)
                ->where('project_team_id', $request->project_team_id)
                ->where('team_id', $request->id)->where('posisi', 'Interviewer')->delete();
        }

        echo $update;
    }
}
