<?php

namespace App\Http\Controllers\Finance;

use App\Divisi;
use App\Helpers\GuzzleRequester;
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
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class RekapTlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $kotas = Project_kota::join('kotas', 'project_kotas.kota_id', '=', 'kotas.id')->select('kotas.*')
            ->when(isset($request->project_id) && $request->project_id != 'all', function ($query) use ($request) {
                return $query->where('project_id', $request->project_id);
            })->orderBy('kotas.kota', 'ASC')->distinct()->get();

        $jabatans = [];
        $errorMessage = null;

        $teams = Project_team::selectRaw("project_teams.*, project_teams.id as project_team_id")->with(['team', 'projectKota' => function ($q) {
            $q->with(['kota']);
        }])
            ->leftJoin('project_kotas', 'project_teams.project_kota_id', '=', 'project_kotas.id')
            ->where('team_leader', '=', 0)
            ->whereNotIn('project_teams.id', function ($query) {
                $query->select('project_team_id')->from('pembayaran_tls');
            })
            ->when(($request->kota_id != 'all' && $request->kota_id), function ($query2) use ($request) {
                return $query2->where('project_kotas.kota_id', '=', $request->kota_id);
            })
            ->when(($request->project_id != 'all' && $request->kotproject_ida_id), function ($query2) use ($request) {
                return $query2->where('project_kotas.project_id', '=', $request->project_id);
            })->orderByDesc('project_teams.id')->get();

        $projects = Project::all()->sortBy('nama');

        $nominalDenda = NominalDenda::when(isset($request->project_id) && $request->project_id != 'all', function ($query) use ($request) {
            return $query->where('project_id', $request->project_id);
        })
            ->when(($request->kota_id != 'all' && $request->kota_id), function ($query2) use ($request) {
                $projectKota = Project_kota::where('kota_id', $request->kota_id)->where('project_id', $request->project_id)->first();
                return $query2->where('selection_id', '=', $projectKota->id)->where('type', 'project_kota');
            })
            ->with(['variable', 'projectKota'])->get();

        $dataNominalDenda = $nominalDenda;

        foreach ($teams as $team) {
            $team->default_honor_do = 0;
            $team->count_respondent_dos = 0;
            $team->total_keterlambatan = 0;
            $team->denda_static = [];
            $team->total_fee = 0;

            $members = Project_team::where('project_kota_id', $team->projectKota->id)->where('team_leader', $team->team_id)->pluck('srvyr');

            $respondents = Respondent::where('project_id', '=', $team->projectKota->project_id)
                ->whereIn('status_qc_id', array(5, 1, 0, 10))->whereIn('srvyr', $members)->get();

            $team->count_respondent_non_dos = $respondents->count();

            $respondentDos = Respondent::where('project_id', '=', $team->projectKota->project_id)
                ->whereIn('status_qc_id', array(2, 3, 6, 9))->whereIn('srvyr', $members)->get();

            $team->count_respondent_dos = $respondentDos->count();

            if ($team->type_tl == "reguler") {
                $team->default_honor = $team->gaji;
                $team->total_fee = $team->default_honor;
            } else if ($team->type_tl == "borongan") {
                $categoryHonorDos = [];
                foreach ($respondentDos as $respondent) {
                    $categoryHonor = $respondent->kategori_honor_do;
                    if ($categoryHonor != "") {
                        isset($categoryHonorDos[$categoryHonor]) ? $categoryHonorDos[$categoryHonor] += 1 : $categoryHonorDos[$categoryHonor] = 1;
                    }
                }

                foreach ($categoryHonorDos as $key => $categoryHonor) {
                    $honor_category = Project_honor_do::where('project_kota_id', $team->project_kota_id)->where('nama_honor_do', $key)->get();

                    foreach ($honor_category as $keyHonor => $value) {
                        $team->default_honor_do += $value->honor_do * $categoryHonor;
                    }
                }

                $categoryHonors = [];
                foreach ($respondents as $respondent) {
                    $categoryHonor = $respondent->kategori_honor;
                    if ($categoryHonor != "") {
                        isset($categoryHonors[$categoryHonor]) ? $categoryHonors[$categoryHonor] += 1 : $categoryHonors[$categoryHonor] = 1;
                    }
                }

                foreach ($categoryHonors as $key => $categoryHonor) {
                    $honor_category = Project_honor::where('project_kota_id', $team->project_kota_id)->where('nama_honor', $key)->get();

                    foreach ($honor_category as $keyHonor => $value) {
                        $team->default_honor += $value->honor * $categoryHonor;
                    }
                }
                $team->total_fee = $team->default_honor;
                $team->total_fee -= $team->default_honor_do;

                $team->total_fee -= 1260000;
            }
            $this->dendaStatic = [];

            $variables = [
                '[total]' => $team->default_honor,
            ];

            foreach ($dataNominalDenda as $denda) {
                if ($denda->selection_id == $team->projectKota->id) {
                    if ($denda->type_variable == null && $denda->variable->variable_name == "Keterlambatan") {
                        $denda->type_variable = "keterlambatan";
                    }

                    try {
                        $methode = $this->methode_count_denda($denda, $team, $members, $variables)[$denda->type_variable];
                        call_user_func_array([$this, $methode['function']], $methode['parameter']);
                    } catch (\Exception $e) {
                        $errorMessage = ['error' => $e->getMessage()];
                        continue;
                    }
                }
            }

            $team->denda_static = $this->dendaStatic;
            $totalDendaStatic = 0;
            foreach ($team->denda_static as $key => $value) {
                $totalDendaStatic += $value->total;
            }
            $team->total_fee -= $totalDendaStatic;

        }

        $jsonData = $teams->toArray();
        $client = new GuzzleRequester();

        return view('finances.rekap_tl.index', compact('teams', 'projects', 'kotas', 'jabatans', 'nominalDenda', 'jsonData','client'))->withErrors($errorMessage);
    }

    public function indexRtp(Request $request)
    {
        $teams = Pembayaran_tl::selectRaw("project_teams.id as project_team_id, pembayaran_tls.*, project_teams.*")
            ->leftJoin('project_teams', 'project_teams.id', '=', 'pembayaran_tls.project_team_id')
            ->leftJoin('project_kotas', 'project_teams.project_kota_id', '=', 'project_kotas.id')
            ->when(($request->project_id != 'all' && $request->kotproject_ida_id), function ($query2) use ($request) {
                return $query2->where('pembayaran_tls.project_id', '=', $request->project_id);
            })
            ->when(($request->kota_id != 'all' && $request->kota_id), function ($query2) use ($request) {
                return $query2->where('project_kotas.kota_id', '=', $request->kota_id);
            })
            ->when(isset($request->status_pembayaran_id) && trim($request->status_pembayaran_id) !== 'all', function ($query2) use ($request) {
                $query2->where('pembayaran_tls.status_pembayaran_id', '=', trim($request->status_pembayaran_id));
            })
            ->get();
        $projects = Project::all()->sortBy('nama');
        $kotas = Project_kota::join('kotas', 'project_kotas.kota_id', '=', 'kotas.id')->select('kotas.*')
            ->when(isset($request->project_id) && $request->project_id != 'all', function ($query) use ($request) {
                return $query->where('project_id', $request->project_id);
            })->orderBy('kotas.kota', 'ASC')->distinct()->get();

            $client = new GuzzleRequester();

        return view('finances.rekap_tl.index_rtp', compact('teams', 'projects', 'kotas', 'client'));
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
            if ($value->team->email == "" && $value->team->hp == "") {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Email atau nomor HP Tidak boleh kosong"
                ];
                continue;
            }

            if ($value->team->email == "" && (strlen($value->team->hp) < 9 || strlen($value->team->hp) > 13)) {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Email kosong atau nomor handphone anda kurang dari 9 atau lebih dari 13 karaketer"
                ];
                continue;
            }

            $project = Project::where('id', $value->project_kota->project_id)->first();
            if (!$project) {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Project tidak ditemukan"
                ];
                continue;
            }

            $itemBpu = Project_budget_integration_tl::select('item_budget_id')->where('project_id', $project->id)->first();
            $projectName = sprintf('%s|%s', $project->nama, $project->nama . ' - ' . $project->methodology);

            $resp = $client->request('GET', 'api/pengajuan/read?name=' . $projectName);
            if ($resp->getStatusCode() != 200) {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Membaca data project $projectName ke Budget Error atau project tidak ditemukan di budget"
                ];
                continue;
            }

            $budget = $resp->getBody()->data;
            $user = User::where('id', session('user_id'))->first();

            $body = [
                "no_item_budget" => $itemBpu->item_budget_id,
                "time_budget" => $budget->waktu,
                "id_user_budget" => $user->id_user_budget,
                "applicant" => session('nama'),
                "division_applicant" => $divisi->nama_divisi,
                "payment_description" => sprintf("%s|%s", $value->type_tl, $value->project_kota->kota->kota),
                "payment_id" => $value->project_team_id . "|tl",
                "type_kas" => 'Kas Project',
                "budget_id" => $budget->noid,
                "total" => $value->total_fee,
                "payment_date" => $this->generatePaymentDate($value->team->kode_bank),
                "recipient" => [
                    "name" => $value->team->nama,
                    "bank_account_number" => $value->team->nomor_rekening,
                    "code_bank" => $value->team->kode_bank,
                    "email" => $value->team->email,
                    "phone_number" => "0895355698652",
                    "bank_account_name" => $value->team->nama,
                ]
            ];

            $resp = $client->request('POST', 'api/bpu/management/create', ["body" => json_encode($body)]);
            if ($resp->getStatusCode() != 200) {
                $dataNotProcess[] = [
                    "data" => $value,
                    "message" => "Gagal melakukan pengajuan."
                ];
                continue;
            }

            $dataBpu = $resp->getBody()->data->data_bpu;
            $dataTransfer = $resp->getBody()->data->data_transfer;
            Pembayaran_tl::insert([
                'project_team_id' => $value->project_team_id,
                'project_id' => $value->project_kota->project_id,
                'total' => $value->total_fee,
                'status_pembayaran_id' => 2,
                'bpu_term' => $dataBpu->term,
                'tanggal_pembayaran' => $dataBpu->tanggalbayar,
                'metode_pembayaran' => $dataBpu->metode_pembayaran,
                'keterangan_pembayaran' => sprintf("%s|%s", $value->type_tl, $value->project_kota->kota->kota),
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
