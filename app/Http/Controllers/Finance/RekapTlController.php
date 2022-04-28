<?php

namespace App\Http\Controllers\Finance;

use App\Divisi;
use App\Http\Controllers\Controller;
use App\Project_honor_do;
use App\Project_plan;
use App\ProjectPlanMaster;
use App\User;
use App\Respondent;
use App\Kota;
use App\Pendidikan;
use App\SesFinal;
use App\Gender;
use App\Pekerjaan;
use App\IsValid;
use App\Jabatan;
use App\NominalDenda;
use App\Pembayaran_tl;
use App\Project;
use App\Project_budget_integration_tl;
use App\Project_honor;
use App\Project_team;
use App\Project_kota;
use App\Team;
use App\Team_payment_marking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapTlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $kotas = Project_kota::join('kotas', 'project_kotas.kota_id', '=', 'kotas.id')->select('kotas.*')
        ->when(isset($request->project_id) && $request->project_id != 'all', function ($query) use ($request) {
            return $query->where('project_id', $request->project_id);
        })->orderBy('kotas.kota', 'ASC')->distinct()->get();

        $jabatans = [];

        $teams = Project_team::with(['team','projectKota' => function($q) {
            $q->with(['kota']);
        }])
        ->leftJoin('project_kotas', 'project_teams.project_kota_id', '=', 'project_kotas.id')
        ->where('team_leader', '=', 0)
        ->whereNotIn('project_teams.id', function ($query) {
            $query->select('project_team_id')->from('pembayaran_tls');
        })
        ->when(($request->kota_id != 'all' && $request->kota_id), function ($query2) use ($request) {
            return $query2->where('project_kotas.kota_id', '=',  $request->kota_id);
        })
        ->when(($request->project_id != 'all' && $request->kotproject_ida_id), function ($query2) use ($request) {
            return $query2->where('project_kotas.project_id', '=',  $request->project_id);
        })->get();

        $projects = Project::all()->sortBy('nama');

        $nominalDenda = NominalDenda::when(isset($request->project_id) && $request->project_id != 'all', function ($query) use ($request) {
            return $query->where('project_id', $request->project_id);
        })
        ->when(($request->kota_id != 'all' && $request->kota_id), function ($query2) use ($request) {
            $projectKota = Project_kota::where('kota_id', $request->kota_id)->where('project_id', $request->project_id)->first();
            return $query2->where('selection_id', '=',  $projectKota->id)->where('type', 'project_kota');
        })
        ->with(['variable','projectKota'])->get();

        $dataNominalDenda = $nominalDenda;

        foreach ($teams as $team) {
            $team->default_honor_do = 0;
            $team->count_respondent_dos = 0;

            $members = Project_team::where('project_kota_id', $team->projectKota->id)->where('team_leader', $team->team_id)->where('srvyr', '!=', "")->pluck('srvyr');
            $respondentDos = Respondent::where('project_id', '=', $team->projectKota->project_id)
                ->where("kota_id", $team->projectKota->kota_id)
                ->whereIn('status_qc_id', array(2, 3, 6, 9))->whereIn('srvyr', $members)->get();

            $team->respondent_dos = $respondentDos;
            $team->count_respondent_dos = $respondentDos->count();
            $team->denda_static = [];

            $categoryHonorDos = [];
            foreach ($respondentDos as $respondent) {
                $categoryHonor = $respondent->kategori_honor_do;
                if ($categoryHonor != "") {
                    if (count($categoryHonorDos) == 0) {
                        isset($categoryHonorDos[$categoryHonor]) ? $categoryHonorDos[$categoryHonor] += 1 : $categoryHonorDos = [$categoryHonor => 1];
                    } else {
                        isset($categoryHonorDos[$categoryHonor]) ? $categoryHonorDos[$categoryHonor] += 1 : $categoryHonorDos = [$categoryHonor => 1];
                    }
                }
            }

            foreach ($categoryHonorDos as $key => $categoryHonor) {
                $honor_category = Project_honor_do::where('project_kota_id', $team->project_kota_id)->where('nama_honor_do', $key)->get();
                foreach ($honor_category as $keyHonor => $value) {
                    $team->default_honor_do += $value->honor_do * $categoryHonor;
                }
            }

            if ($team->type_tl == "reguler") {
                $team->default_honor = $team->gaji;
            } else if ($team->type_tl == "borongan") {
                $respondents = Respondent::where('project_id', '=', $team->projectKota->project_id)
                    ->where("kota_id", $team->projectKota->kota_id)
                    ->whereIn('status_qc_id', array(5, 1, 0, 10))->whereIn('srvyr', $members)->get();

                $categoryHonors = [];
                foreach ($respondents as $respondent) {
                    $categoryHonor = $respondent->kategori_honor;
                    if ($categoryHonor != "") {
                        if (count($categoryHonors) == 0) {
                            isset($categoryHonors[$categoryHonor]) ? $categoryHonors[$categoryHonor] += 1 : $categoryHonors = [$categoryHonor => 1];
                        } else {
                            isset($categoryHonors[$categoryHonor]) ? $categoryHonors[$categoryHonor] += 1 : $categoryHonors = [$categoryHonor => 1];
                        }
                    }
                }

                foreach ($categoryHonors as $key => $categoryHonor) {
                    $honor_category = Project_honor::where('project_kota_id', $team->project_kota_id)->where('nama_honor', $key)->get();

                    foreach ($honor_category as $keyHonor => $value) {
                        $team->default_honor += $value->honor * $categoryHonor;
                    }
                }

                $variables = [
                  '[total]' => $team->default_honor,
                ];

                $team->denda_static = [];
                foreach ($dataNominalDenda as $denda) {
                    if ($denda->variable->variable_name == 'Keterlambatan' && $denda->selection_id == $team->projectKota->id) {
                        $projectPlans = Project_plan::where('ket', 'Field Work')->where('project_id', $team->projectKota->project_id)->first();
                        $id = $denda->id;

                        if ($projectPlans) {
                            $respondentsDenda = Respondent::where('project_id', '=', $team->projectKota->project_id)
                                ->where("kota_id", $team->projectKota->kota_id)
                                ->whereDate('intvdate', '>=', $projectPlans->date_finish_real)
                                ->whereIn('srvyr', $members)->count();

                            isset($team->denda_static[$id]) ?  $team->denda_static[$id] = (int)((float)((int)$denda->nominal * ((int)strtr($denda->from, $variables))) * $respondentsDenda)
                                : $team->denda_static = [
                                    $id => (int)((float)$denda->nominal * ((int)strtr($denda->from, $variables))) * $respondentsDenda
                            ];

                        }

                    }
                }

            }
        }

        return view('finances.rekap_tl.index', compact('teams', 'projects', 'kotas', 'jabatans', 'nominalDenda'));
    }

    public function indexRtp(Request $request)
    {
        if ($request->project_id != 'all' && $request->project_id) {
            $teams = Pembayaran_tl::select('project_teams.*', 'teams.nama', 'teams.alamat', 'teams.hp', 'teams.email', 'teams.kode_bank', 'teams.nomor_rekening', 'kotas.kota', 'pembayaran_tls.status_pembayaran_id', 'pembayaran_tls.total', 'pembayaran_tls.id', 'pembayaran_tls.metode_pembayaran')
                ->join('project_teams', 'project_teams.id', '=', 'pembayaran_tls.project_team_id')
                ->join('teams', 'teams.id', '=', 'project_teams.team_id')
                ->join('kotas', 'kotas.id', '=', 'teams.kota_id')
                ->join('project_jabatans', 'project_jabatans.id', '=', 'project_teams.project_jabatan_id')
                ->where('pembayaran_tls.project_id', '=', $request->project_id)
                ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                    return $query->where('teams.kota_id', '=', $request->kota_id);
                })
                ->when(isset($request->status_pembayaran_id) && trim($request->status_pembayaran_id) !== 'all', function ($query2) use ($request) {
                    $query2->where('pembayaran_tls.status_pembayaran_id', '=', trim($request->status_pembayaran_id));
                })
                ->when(($request->jabatan_id != 'all' && $request->jabatan_id), function ($query2) use ($request) {
                    return $query2->where('project_jabatans.jabatan_id', '=',  $request->jabatan_id);
                })
                ->get();

            // dd($teams);

            $kotas = Respondent::join('kotas', 'respondents.kota_id', '=', 'kotas.id')->select('kotas.*')->where('project_id', '=', $request->project_id)->orderBy('kotas.kota', 'ASC')->distinct()->get();

            $jabatans = DB::select('SELECT pk.kota_id AS id_kota,
            pk.id AS project_kota_id, pj.id AS project_jabatan_id, j.jabatan, pj.jabatan_id AS id
            FROM  project_kotas pk
                LEFT JOIN project_jabatans pj ON pk.id = pj.project_kota_id
                LEFT JOIN jabatans j ON pj.jabatan_id = j.id
                JOIN project_budget_integration_tls pb ON pj.jabatan_id = pb.jabatan_id
            WHERE pk.project_id = ' . $request->project_id .
                ' AND pb.item_budget_id IS NOT NULL GROUP BY jabatan');
            // dd(count($teams));
        } else {

            $teams = Pembayaran_tl::select('project_teams.*', 'teams.nama', 'teams.alamat', 'teams.hp', 'teams.email', 'teams.kode_bank', 'teams.nomor_rekening', 'kotas.kota', 'pembayaran_tls.status_pembayaran_id', 'pembayaran_tls.total', 'pembayaran_tls.id')
                ->join('project_teams', 'project_teams.id', '=', 'pembayaran_tls.project_team_id')
                ->join('teams', 'teams.id', '=', 'project_teams.team_id')
                ->join('kotas', 'kotas.id', '=', 'teams.kota_id')
                ->when(isset($request->status_pembayaran_id) && trim($request->status_pembayaran_id) !== 'all', function ($query2) use ($request) {
                    $query2->where('pembayaran_tls.status_pembayaran_id', '=', trim($request->status_pembayaran_id));
                })
                ->get();

            // dd(count($teams));
            $kotas = Kota::all()->sortBy('kota');
            $jabatans = Jabatan::all()->sortBy('jabatan');
        }
        // dd($teams);
        $projects = Project::all()->sortBy('nama');
        $pendidikans = Pendidikan::all()->sortBy('pendidikan');
        $ses_finals = SesFinal::all();
        $genders = Gender::all();
        // $teams = Team::all();
        $pekerjaans = Pekerjaan::all()->sortBy('pekerjaan');
        $is_valids = Isvalid::all();

        // $menus = Menu::all();
        $add_url = url('/menus/create');
        // $kotas = Kota::all()->sortBy('kota');
        return view('finances.rekap_tl.index_rtp', compact('teams', 'add_url', 'projects', 'kotas', 'pendidikans', 'ses_finals', 'genders', 'teams', 'pekerjaans', 'is_valids', 'jabatans'));
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
        // dd($request);
        // $request->project_id = 33;
        $nextStatus = $request->nextStatus;
        $divisi = Divisi::where("id", session('divisi_id'))->first();
        // dd('here');
        if ($nextStatus == 2) {


            // $team = Team::where('id', $projectTeam->team_id)->first();
        } else {
            $projectTeam = Pembayaran_tl::select('pembayaran_tls.*', 'project_teams.team_id')
                ->join('project_teams', 'project_teams.id', '=', 'pembayaran_tls.project_team_id')
                ->where('pembayaran_tls.id', $request->id)
                ->first();
        }

        // dd($projectTeam);
        // dd($projectTeam);

        // if (!isset($team->kode_bank) || !isset($team->nomor_rekening)) {
        //     return redirect(url()->previous())->with('status-fail', 'Data kepemilikan bank atau nomor rekening belum ada');
        // }

        $project = Project::where('id', $request->project_id)->first();

        // dd($project);

        $itemBpu = Project_budget_integration_tl::select('item_budget_id')->where('project_id', $project->id)->where('jabatan_id', $request->jabatan_id)->first();

        $budget =  DB::connection('mysql2')->table('pengajuan')->select('*')->where('nama', $project->nama)->first();

        // dd($budget);
        if (isset($budget)) {
            $term = DB::connection('mysql2')->table('bpu')->where('no', $itemBpu->item_budget_id)->where('waktu', $budget->waktu)->max('term');

            $selesai = DB::connection('mysql2')->table('selesai')->where('no', $itemBpu->item_budget_id)->where('waktu', $budget->waktu)->first();

            $user = User::where('id', session('user_id'))->first();

            $userBudget = DB::connection('mysql2')->table('tb_user')->where('id_user', $user->id_user_budget)->first();

            $get_kas = DB::connection('mysql5')->table('kas')->select('*')->where('label_kas', 'Kas Project')->first();

            $get_jenis_pembayaran = DB::connection('mysql6')->table('jenis_pembayaran')->select('*')->where('jenispembayaran', $selesai->status)->first();

            if ($nextStatus == 2) {

                for ($i = 0; $i < count($request->id); $i++) {
                    $projectTeam = Project_team::select('project_teams.*', 'project_kotas.project_id AS project_id')
                        ->join('project_jabatans', 'project_jabatans.id', '=', 'project_teams.project_jabatan_id')
                        ->join('project_kotas', 'project_kotas.id', '=', 'project_jabatans.project_kota_id')
                        ->where('project_teams.id', $request->id[$i])->first();


                    $team = Team::where('id', $projectTeam->team_id)->first();

                    $bank = DB::connection('mysql3')->table('bank')->select('*')->where('kode', $team->kode_bank)->first();

                    $total = "total-" . $request->id[$i];

                    if ($get_jenis_pembayaran) {
                        if ($request->total > $get_jenis_pembayaran->max_transfer) {
                            $metode_pembayaran = 'MRI Kas';
                        } else {
                            $metode_pembayaran = 'MRI PAL';
                        }
                    }

                    $insertBpu = DB::connection('mysql2')->table('bpu')->insert([
                        'no' => $itemBpu->item_budget_id,
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

                    $update = Pembayaran_tl::insert([
                        'project_team_id' => $request->id[$i],
                        'project_id' => $project->id,
                        'total' => $request->$total,
                        'status_pembayaran_id' => $nextStatus,
                        'bpu_term' => $term + 1,
                        'metode_pembayaran' => $metode_pembayaran,
                        'bpu_noid' => $noid->noid,
                        'tanggal_pengajuan' => date('Y-m-d'),
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    $date = date('my');
                    $count = DB::connection('mysql4')->table('data_transfer')->select('transfer_req_id')->where('transfer_req_id', 'like', $date . '%')->orderBy('transfer_req_id', 'desc')->first();
                    $count = (int)substr($count->transfer_req_id, -4);
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
                }
            } else if ($nextStatus == 3) {
                $arrId = explode(',', $request->id);
                $arrTotal = explode(',', $request->total);

                for ($i = 0; $i < count($arrId); $i++) {
                    $pembayaranTl = Pembayaran_tl::where('id', $arrId[$i])->first();
                    $update = Pembayaran_tl::where('id', $pembayaranTl->id)->update([
                        'status_pembayaran_id' => $nextStatus,
                        'keterangan_pembayaran' => $request->ket_pembayaran,
                        'tanggal_pembayaran' => date('Y-m-d'),
                    ]);

                    $insertBpu = DB::connection('mysql2')->table('bpu')->where('noid', $pembayaranTl->bpu_noid)->update([
                        'jumlahbayar' => $arrTotal[$i],
                        'persetujuan' => 'Disetujui oleh sistem',
                        'status' => 'Telah Di Bayar',
                    ]);
                }
            } else if ($nextStatus == 4) {
                $arrId = explode(',', $request->id);
                $arrTotal = explode(',', $request->total);

                for ($i = 0; $i < count($arrId); $i++) {
                    $pembayaranTl = Pembayaran_tl::where('id', $arrId[$i])->first();
                    $update = Pembayaran_tl::where('id', $pembayaranTl->id)->update([
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

        session(['current_project_id' => $request->id]);

        $teams = DB::select('SELECT pk.kota_id AS id_kota,
        pk.jumlah AS jumlah, pk.id AS project_kota_id, pj.id AS project_jabatan_id, pt.id AS project_team_id, k.kota, j.jabatan, t.nama AS team, xx.nama AS nama_prov, pt.gaji, pt.denda, pt.team_id
    FROM  project_kotas pk
        LEFT JOIN project_jabatans pj ON pk.id = pj.project_kota_id
        LEFT JOIN project_teams pt ON pj.id = pt.project_jabatan_id
        LEFT JOIN kotas k ON pk.kota_id = k.id
        LEFT JOIN jabatans j ON pj.jabatan_id = j.id
        LEFT JOIN teams t ON pt.team_id = t.id
        LEFT JOIN provinsi xx ON pk.id_provinsi = xx.id
    WHERE pk.project_id = ' . $request->id .
            ' AND pj.jabatan_id = ' . $request->jabatan_id . ' AND t.nama IS NOT NULL ORDER BY team;');

        return view('finances.rekap_tl.marking', compact('teams'));
    }


    public function updateMarking(Request $request)
    {
        if ($request->status == 'mark') {
            $checkData = Team_payment_marking::where('project_id', $request->project_id)->where('team_id', $request->id)->where('posisi', 'Interviewer')->count();
            if (!$checkData) {
                $update = Team_payment_marking::insert([
                    'project_id' => $request->project_id,
                    'team_id' => $request->id,
                    'posisi' => $request->jabatan,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        } else if ($request->status == 'unmark') {
            $update = Team_payment_marking::where('project_id', $request->project_id)->where('team_id', $request->id)->where('posisi', $request->jabatan)->delete();
        }

        echo $update;
    }
}
