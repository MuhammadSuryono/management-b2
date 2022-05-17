<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\NominalDenda;
use App\Project_honor;
use App\Project_honor_do;
use App\Project_plan;
use App\Project_team;
use App\Respondent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPayment extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function detail($projectTeamId)
    {
        $projectTeam = Project_team::find($projectTeamId);
        $members = Project_team::where('project_kota_id', $projectTeam->projectKota->id)->where('team_leader', $projectTeam->team_id)->pluck('srvyr');

        $projectTeam->honor_do = [];
        $projectTeam->default_honor = 0;
        $projectTeam->total_fee = 0;
        $projectTeam->count_respondent_do_stg = 0;
        $projectTeam->honor_do = [];
        $projectTeam->data_honor = [];

        $dataHonor = [];
        $dataHonorDoStg = [];

        $respondents = Respondent::where('project_id', '=', $projectTeam->projectKota->project_id)
            ->whereIn('status_qc_id', array(5, 1, 0, 10))->whereIn('srvyr', $members)->get();

        $projectTeam->respondent_non_do = $respondents->count();

        $respondentStgDos = Respondent::where('project_id', '=', $projectTeam->projectKota->project_id)
            ->whereIn('status_qc_id', array(2, 3, 6, 9))->whereIn('srvyr', $members)->get();

        $projectTeam->count_respondent_do_stg = $respondentStgDos->count();

        $nominalDenda = NominalDenda::where('project_id', $projectTeam->projectKota->project_id)
            ->where('selection_id', '=', $projectTeam->projectKota->id)->where('type', 'project_kota')
            ->with(['variable', 'projectKota'])->get();

        if ($projectTeam->type_tl == "reguler") {
            $dataHonor[] = (object)[
                'nama_honor' => 'Diem',
                'jumlah' => $projectTeam->gaji,
                'total_respondent' => $projectTeam->respondent_non_do,
                'satuan' => "diem",
                'total_honor' => $projectTeam->gaji
            ];
            $projectTeam->data_honor = $dataHonor;
            $projectTeam->default_honor = $projectTeam->gaji;
            $projectTeam->total_fee = $projectTeam->default_honor;

            $dataHonorDoStg[] = (object)[
                'nama_honor_denda' => "DO STG Anggota",
                'nominal' => 0,
                'quantity_data' => $projectTeam->count_respondent_do_stg,
                'satuan' => "respondent",
                'kategori' => $projectTeam->projectKota->kota->kota,
                'total' => 0 * $projectTeam->count_respondent_do_stg
            ];

        } elseif($projectTeam->type_tl == "borongan") {
            $categoryHonors = [];
            foreach ($respondents as $respondent) {
                $categoryHonor = $respondent->kategori_honor;
                if ($categoryHonor != "") {
                    isset($categoryHonors[$categoryHonor]) ? $categoryHonors[$categoryHonor] += 1 : $categoryHonors[$categoryHonor] = 1;
                } else {
                    isset($categoryHonors["Undefined"]) ? $categoryHonors["Undefined"] += 1 :  $categoryHonors["Undefined"] = 1;
                }
            }

            foreach ($categoryHonors as $key => $totalRespondent) {
                $honor_category = Project_honor::where('project_kota_id', $projectTeam->project_kota_id)->where('nama_honor', $key)->get();
                if ($honor_category->isEmpty()) {
                    $dataHonor[] = (object)[
                        'nama_honor' => $key,
                        'jumlah' => 0,
                        'total_respondent' => $totalRespondent,
                        'satuan' => "respondent",
                        'total_honor' => 0 * $totalRespondent
                    ];
                }
                foreach ($honor_category as $keyHonor => $value) {
                    $projectTeam->default_honor += $value->honor * $totalRespondent;
                    $dataHonor[] = (object)[
                        'nama_honor' => $key,
                        'jumlah' => (int)$value->honor,
                        'total_respondent' => $totalRespondent,
                        'satuan' => "respondent",
                        'total_honor' => $value->honor * $totalRespondent
                    ];
                }

            }
            $projectTeam->data_honor = $dataHonor;
            $projectTeam->total_fee = $projectTeam->default_honor;

            $categoryHonorDos = [];
            foreach ($respondentStgDos as $respondent) {
                $categoryHonor = $respondent->kategori_honor_do;
                if ($categoryHonor != "" || $categoryHonor != null) {
                    isset($categoryHonorDos[$categoryHonor]) ? $categoryHonorDos[$categoryHonor] += 1 : $categoryHonorDos[$categoryHonor] = 1;
                } else {
                    isset($categoryHonorDos["Undefined"]) ? $categoryHonorDos["Undefined"] += 1 : $categoryHonorDos["Undefined"] = 1;
                }
            }

            foreach ($categoryHonorDos as $key => $totalRespondent) {
                $honor_category = Project_honor_do::where('project_kota_id', $projectTeam->project_kota_id)->where('nama_honor_do', $key)->get();
                if ($honor_category->isEmpty()) {
                    $dataHonorDoStg[] = (object)[
                        'nama_honor_denda' => $key,
                        'nominal' => 0,
                        'quantity_data' => $totalRespondent,
                        'satuan' => "respondent",
                        'kategori' => $projectTeam->projectKota->kota->kota,
                        'total' => 0 * $totalRespondent
                    ];
                }

                foreach ($honor_category as $keyHonor => $value) {
                    $projectTeam->default_honor_do_stg += $value->honor_do * $totalRespondent;
                    $projectTeam->total_fee -= $value->honor_do * $totalRespondent;
                    $dataHonorDoStg[] = (object)[
                        'nama_honor_denda' => $key,
                        'nominal' => (int)$value->honor_do,
                        'quantity_data' => $totalRespondent,
                        'satuan' => "respondent",
                        'kategori' => $projectTeam->projectKota->kota->kota,
                        'total' => $value->honor_do * $totalRespondent
                    ];
                }
            }
        }

        $projectTeam->honor_do = [
            "DO STG" => $dataHonorDoStg
        ];

        $variables = [
            '[total]' => $projectTeam->default_honor,
        ];

        foreach ($nominalDenda as $denda) {
            if ($denda->selection_id == $projectTeam->projectKota->id) {
                if ($denda->type_variable == null && $denda->variable->variable_name == "Keterlambatan") {
                    $denda->type_variable = "keterlambatan";
                }

                try {
                    $methode = $this->methode_count_denda($denda, $projectTeam, $members, $variables)[$denda->type_variable];
                    call_user_func_array([$this, $methode['function']], $methode['parameter']);
                } catch (\Exception $e) {
                    dd($e->getMessage(), $e->getLine(), $e->getFile(), $e->getTrace());
                    continue;
                }
            }
        }

        $dataPotonganDynamic = [];
        foreach ($nominalDenda as $denda){
            if($this->dendaStatic != null){
                if(isset($this->dendaStatic[$denda->id])){
                    $projectTeam->total_fee -= $this->dendaStatic[$denda->id]->total;
                    $dataPotonganDynamic[$denda->type_variable][] = $this->dendaStatic[$denda->id];
                }
            }
        }
        $projectTeam->honor_do = array_merge($projectTeam->honor_do, $dataPotonganDynamic);

        return view('finances.detail_payment', compact('projectTeam'));
    }

    public function getDetailData(): JsonResponse
    {
        $projectTeamId = $this->request->projectTeamId;
        $data = base64_decode($this->request->data);
        $data = json_decode($data);
        $type = $this->request->type;

        $projectTeam = Project_team::find($projectTeamId);
        $members = Project_team::where('project_kota_id', $projectTeam->projectKota->id)->where('team_leader', $projectTeam->team_id)->pluck('srvyr');
        try {
            $methode = $this->methode_detail_quantity_data($projectTeam, $members, $data)[$type];
            $resp = call_user_func_array([$this, $methode['function']], $methode['parameter']);
        }catch (\Exception $e){
            dd($e->getMessage(), $e->getLine(), $e->getFile(), $e->getTrace());
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
        return response()->json(['data' => $resp, 'status' => true]);
    }

    public function methode_detail_quantity_data($projectTeam, $members, $data): array
    {
        return [
            "non_do" => [
                'function' => 'get_respondent_non_do',
                'parameter' => [$projectTeam, $members]
            ],
            "DO STG" => [
                'function' => 'get_respondent_do_stg',
                'parameter' => [$projectTeam, $members, $data]
            ],
            "keterlambatan" => [
                'function' => 'get_respondent_do_keterlambatan',
                'parameter' => [$projectTeam, $members]
            ],
            "gift" => [
                'function' => 'get_respondent_gift',
                'parameter' => [$projectTeam, $members, $data]
            ]
        ];
    }

    public function get_respondent_non_do($projectTeam, $members)
    {
        return Respondent::with(['kota'])->where('project_id', '=', $projectTeam->projectKota->project_id)
            ->whereIn('status_qc_id', array(5, 1, 0, 10))->whereIn('srvyr', $members)->get();
    }

    public function get_respondent_do_stg($projectTeam, $members, $data)
    {

        $resp =  Respondent::with(['kota'])->where('project_id', '=', $projectTeam->projectKota->project_id)
            ->whereIn('status_qc_id', array(2, 3, 6, 9))->whereIn('srvyr', $members);

        if($projectTeam->type_tl != 'reguler') {
            $resp = $resp->where('kategori_honor_do', '=', $data->nama_honor_denda != "Undefined" ? $data->nama_honor_denda : null);
        }
        return $resp->get();
    }

    public function get_respondent_do_keterlambatan($projectTeam, $members)
    {
        $projectPlans = Project_plan::where('ket', 'Field Work')->where('project_id', $projectTeam->projectKota->project_id)->first();
        return Respondent::with(['kota'])->where('project_id', '=', $projectTeam->projectKota->project_id)
            ->where("kota_id", $projectTeam->projectKota->kota_id)
            ->whereDate('intvdate', '>', $projectPlans->date_finish_real)
            ->whereIn('srvyr', $members)
            ->orderBy('intvdate', 'asc')
            ->get();
    }

    public function get_respondent_gift($projectTeam, $members, $data)
    {
        $respondents = Respondent::with(['kota'])->where('project_id', '=', $projectTeam->projectKota->project_id)
            ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            ->where("kota_id", $projectTeam->projectKota->kota_id)
            ->whereIn('srvyr', $members);

        if ($data->diambil_dari == '[respondent_do]') {
            $respondents = $respondents->where('respondent_gifts.status_pembayaran_id', 3)
                ->whereIn('status_qc_id', array(2, 3, 6, 9));
        }

        if ($data->diambil_dari == '[respondent]') {
            $respondents = $respondents->where('respondent_gifts.status_pembayaran_id', 3)
                ->whereIn('status_qc_id', array(5, 1, 0, 10));
        }

        return $respondents->get();
    }

}
