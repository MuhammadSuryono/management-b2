<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\GuzzleRequester;
use App\Http\Controllers\Controller;
use App\Pembayaran_tl;
use App\Project_budget_integration_tl;
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
                DB::enableQueryLog();
                $dbDigitalisasiMarketing = DB::connection('mysql3');
                $teamPaymentMarking = Team_payment_marking::select("team_payment_markings.*")->with(['team','projectTeam'])
                    ->leftJoin('project_teams', 'project_teams.id', '=', 'team_payment_markings.project_team_id')
                    ->leftJoin('project_kotas', 'project_kotas.id', '=', 'project_teams.project_kota_id')
                    ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                        return $query->where('team_payment_markings.kota_id', '=', $request->kota_id);
                    })
                    ->whereNotIn('team_payment_markings.project_team_id', function ($query) {
                        $query->select('team_id')->from('pembayaran_interviewers');
                    })
                    ->where('team_payment_markings.project_id', $request->project_id)
                    ->where('posisi', 'Interviewer')
                    ->get();

                $teams = [];
                if ($teamPaymentMarking != null) {
                    foreach ($teamPaymentMarking as $team) {
                        $bank = $dbDigitalisasiMarketing->table('bank')->where('kode', '=', $team->team->kode_bank)->first();
                        $team->team->bank = $bank != null ? $bank->nama : "-";

                        $bgColor = "";
                        $isCanMarking = true;
                        if ($team->team->bank == null && $team->team->nomor_rekening == "") {
                            $isCanMarking = false;
                            $bgColor = "bg-danger";
                        }
                        $team->team->is_can_marking = $isCanMarking;
                        $team->team->bg_color = $bgColor;
                        $team->team->project_team_id = $team->project_team_id;
                        $team->team->project_id = $team->project_id;
                        $teams[] = $team->team;
                    }
                }

            } else if (in_array('internal', $pembayaran_interviewer)) {
                $respondents = Respondent::where('project_id', '=', $request->project_id)
                    ->when(isset($request->kota_id) && $request->kota_id != 'all', function ($query) use ($request) {
                        return $query->where('kota_id', '=', $request->kota_id);
                    })
                    ->groupBy('respondents.id')
                    ->get();
                $dbDigitalisasiMarketing = DB::connection('mysql3');

                $teams = [];
                $checkId = [];
                foreach ($respondents as $r) {
                    if ($r->srvyr) {

                        $projectTeam = Project_team::with(['team','projectKota' => function($q) {
                            $q->with(['kota']);
                        }])
                            ->leftJoin('project_kotas', 'project_teams.project_kota_id', '=', 'project_kotas.id')
                            ->where('team_leader', '!=', 0)
                            ->where('project_kotas.project_id', $request->project_id)
                            ->where('srvyr', $r->srvyr)->first();

                        if ($projectTeam != null) {
                            $leader = Project_team::where("project_kota_id", $projectTeam->project_kota_id)->where('team_leader', $projectTeam->team_leader)->first();
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
                                        $pwt->project_id = $projectKota->project_id;

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

        $honor_category = [];
        $honor_do_category = [];
        if (isset($request->project_id)) {
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
        }

        $projects = Project::all()->sortBy('nama');
        $pendidikans = Pendidikan::all()->sortBy('pendidikan');
        $ses_finals = SesFinal::all();
        $genders = Gender::all();
        $pekerjaans = Pekerjaan::all()->sortBy('pekerjaan');
        $is_valids = Isvalid::all();

        return view('finances.rekap_interviewer.index', compact('teams',  'projects', 'kotas', 'pendidikans', 'ses_finals', 'genders', 'teams', 'pekerjaans', 'is_valids', 'honor_category', 'honor_do_category'));
    }

    public function indexRtp(Request $request)
    {
        $teams = Pembayaran_interviewer::selectRaw("project_teams.id as project_team_id, pembayaran_interviewers.*, project_teams.*")
            ->leftJoin('project_teams', 'project_teams.id', '=', 'pembayaran_interviewers.team_id')
            ->leftJoin('project_kotas', 'project_teams.project_kota_id', '=', 'project_kotas.id')
            ->when(($request->project_id != 'all' && $request->kotproject_ida_id), function ($query2) use ($request) {
                return $query2->where('pembayaran_interviewers.project_id', '=', $request->project_id);
            })
            ->when(($request->kota_id != 'all' && $request->kota_id), function ($query2) use ($request) {
                return $query2->where('project_kotas.kota_id', '=', $request->kota_id);
            })
            ->when(isset($request->status_pembayaran_id) && trim($request->status_pembayaran_id) !== 'all', function ($query2) use ($request) {
                $query2->where('pembayaran_interviewers.status_pembayaran_id', '=', trim($request->status_pembayaran_id));
            })
            ->get();
        $projects = Project::all()->sortBy('nama');
        $kotas = Project_kota::join('kotas', 'project_kotas.kota_id', '=', 'kotas.id')->select('kotas.*')
            ->when(isset($request->project_id) && $request->project_id != 'all', function ($query) use ($request) {
                return $query->where('project_id', $request->project_id);
            })->orderBy('kotas.kota', 'ASC')->distinct()->get();

        return view('finances.rekap_interviewer.index_rtp', compact('teams', 'projects', 'kotas'));
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
        $this->validate($request, [
            'data' => 'required|array',
            '_token' => 'required',
        ]);
        $dataNotProcess = [];
        $client = new GuzzleRequester();
        $divisi = Divisi::where("id", session('divisi_id'))->first();
        if ($divisi == null) {
            return response()->json(["status" => false, "message" => "Divisi user undefined"]);
        }

        $data = json_decode(json_encode($request->all()), FALSE);
        foreach ($data->data as $key => $value) {
            if ($value->email == "" && $value->hp == "") {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Email atau nomor HP Tidak boleh kosong"
                ];
                continue;
            }

            if ($value->email == "" && (strlen($value->hp) < 9 || strlen($value->hp) > 13)) {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Email kosong atau nomor handphone anda kurang dari 9 atau lebih dari 13 karaketer"
                ];
                continue;
            }

            $project = Project::where('id', $value->project_id)->first();
            if (!$project) {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Project tidak ditemukan"
                ];
                continue;
            }

            $itemBpu = Project_budget_integration::where('project_id', $project->id)->first();
            $projectName = sprintf('%s|%s', $project->nama, $project->nama . ' - ' . $project->methodology);
            $resp = $client->request('GET', '/api/pengajuan/read?name=' . $projectName);
            if ($resp->getStatusCode() != 200) {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Membaca data project $projectName ke Budget Error atau project tidak ditemukan di budget"
                ];
                continue;
            }

            $budget = $resp->getBody()->data;
            $user = User::where('id', session('user_id'))->first();

            $bank = DB::connection('mysql3')->table('bank')->where('kode', '=', $value->kode_bank)->first();
            if (!$bank) {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Bank anda tidak terdaftar"
                ];
                continue;
            }

            $body = [
                "no_item_budget" => $itemBpu->item_budget_id_pembayaran_interviewer,
                "time_budget" => $budget->waktu,
                "id_user_budget" => $user->id_user_budget,
                "applicant" => session('nama'),
                "division_applicant" => $divisi->nama_divisi,
                "payment_description" => sprintf("%s", $value->kota->kota),
                "payment_id" => $value->project_team_id,
                "type_kas" => 'Kas Project',
                "budget_id" => $budget->noid,
                "total" => $value->total_fee,
                "payment_date" => $this->generatePaymentDate($bank->swift_code),
                "recipient" => [
                    "name" => $value->nama,
                    "bank_account_number" => $value->nomor_rekening,
                    "code_bank" => $bank->swift_code,
                    "email" => $value->email,
                    "phone_number" => $value->hp,
                    "bank_account_name" => $value->nama,
                ]
            ];

            $resp = $client->request('POST', '/api/bpu/management/create', ["body" => json_encode($body)]);

            $dataBpu = $resp->getBody()->data->data_bpu;
            $dataTransfer = $resp->getBody()->data->data_transfer;
            Pembayaran_interviewer::insert([
                'team_id' => $value->project_team_id,
                'project_id' => $value->project_id,
                'total' => $value->total_fee,
                'status_pembayaran_id' => 2,
                'bpu_term' => $dataBpu->term,
                'tanggal_pembayaran' => $dataBpu->tanggalbayar,
                'metode_pembayaran' => $dataBpu->metode_pembayaran,
                'keterangan_pembayaran' => sprintf("%s", $value->kota->kota),
                'bpu_noid' => $dataBpu->noid,
                'tanggal_pengajuan' => date('Y-m-d'),
            ]);
        }

        $message = "";
        if (count($dataNotProcess) > 0) {
            $message = "Data berikut tidak dapat diproses, dengan keterangan: ";
            $notProcess = "";
            foreach ($dataNotProcess as $key => $value) {
                $notProcess = $value["data"]->team->nama;
                $reason = $value["message"];
                $notProcess = sprintf("%s: %s", $notProcess, $reason);
                if ($key + 1 < count($dataNotProcess)) {
                    $notProcess = ", ";
                };
            }

            $message = $message . " " . $notProcess . ". Mohon periksa kembali data berikut";
        }else {
            $message = "Data anda berhasil di ajukan.";
        }

        return response()->json(["status" => true, "message" => $message]);
    }

    public function marking(Request $request)
    {
        $respondents = Respondent::where('project_id', '=', $request->id)
            ->get();
        $dbDigitalisasiMarketing = DB::connection('mysql3');

        $teams = [];
        $checkId = [];

        foreach ($respondents as $k => $r) {
            if ($r->srvyr) {
                $projectTeam = Project_team::select("project_teams.*")->with(['team','projectKota' => function($q) {
                    $q->with(['kota']);
                }])
                    ->leftJoin('project_kotas', 'project_teams.project_kota_id', '=', 'project_kotas.id')
                    ->where('team_leader', '!=', 0)
                    ->where('project_kotas.project_id', $request->id)
                    ->where('srvyr', $r->srvyr)->first();

                if ($projectTeam != null) {
                    $leader = Project_team::where("project_kota_id", $projectTeam->project_kota_id)->where('team_leader', $projectTeam->team_leader)->first();
                    if (isset($projectTeam->team) && $leader->type_tl != "borongan") {
                        $projectKota = $projectTeam->projectKota;
                        $pwt = $projectTeam->team;
                        if (!in_array($pwt->id, $checkId)) {
                            $bank = $dbDigitalisasiMarketing->table('bank')->where('kode', '=', $pwt->kode_bank)->first();
                            $pwt->type_tl = $leader->type_tl;
                            $pwt->project_kota = $projectKota->kota->kota;
                            $pwt->project_kota_id = $projectKota->kota_id;
                            $pwt->bank = $bank != null ? $bank->nama : "-";
                            $pwt->project_team_id = $projectTeam->id;
                            $pwt->project_id = $projectKota->project_id;

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
            $checkData = Team_payment_marking::where('project_id', $request->project_id)
                ->where('team_id', $request->id)
                ->where('project_team_id', $request->project_team_id)
                ->where('posisi', 'Interviewer')->count();
            if ($checkData == null) {
                $update = Team_payment_marking::insert([
                    'project_id' => $request->project_id,
                    'team_id' => $request->id,
                    'posisi' => 'Interviewer',
                    'project_team_id' => $request->project_team_id,
                    'kota_id' => $request->kota_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                echo $update;
                return;
            }
        } else if ($request->status == 'unmark') {
            $update = Team_payment_marking::where('project_id', $request->project_id)
                ->where('project_team_id', $request->project_team_id)
                ->where('team_id', $request->id)->where('posisi', 'Interviewer')->delete();

            echo $update;
            return;
        }

        echo $request->status;
    }
}
