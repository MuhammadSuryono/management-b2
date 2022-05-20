<?php

namespace App\Http\Controllers;

use App\Project_plan;
use App\Respondent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $dendaStatic = [];


    public function methode_count_denda($denda, $team, $members, $variables)
    {
        return [
            'keterlambatan' => [
                'function' => 'count_denda_keterlambatan',
                'parameter' => [$denda, $team, $members, $variables]
            ],
            'gift' => [
                'function' => 'count_denda_do_gift',
                'parameter' => [$denda, $team, $members, $variables]
            ],
            'btf' => [
                'function' => 'count_denda_btf',
                'parameter' => [$denda, $team, $members, $variables]
            ],
            'input_manual' => [
                'function' => 'count_denda_manual',
                'parameter' => [$denda, $team, $members, $variables]
            ]
        ];
    }

    public function count_denda_keterlambatan($denda, $team, $members, $variables)
    {
        $projectPlans = Project_plan::where('ket', 'Field Work')->where('project_id', $team->projectKota->project_id)->first();
        $id = $denda->id;

        if ($projectPlans) {
            $respondentsDenda = Respondent::select(DB::raw('DATE(intvdate) as hari_keterlambatan'))->where('project_id', '=', $team->projectKota->project_id)
                ->where("kota_id", $team->projectKota->kota_id)
                ->whereDate('intvdate', '>', $projectPlans->date_finish_real)
                ->whereIn('srvyr', $members)
                ->groupBy('hari_keterlambatan')
                ->get();
            $respondentsDenda = $respondentsDenda->count();
            $team->total_keterlambatan = $respondentsDenda;
            $dataDenda = (int)(((float)$denda->nominal / 100) * ((int)strtr($denda->from, $variables))) * $respondentsDenda;

            if(isset($this->dendaStatic[$id])) {
                $this->dendaStatic[$id]->total += $dataDenda;
            }  else {
                $this->dendaStatic[$id] = (object)[
                    "nama_honor_denda" => $denda->variable->variable_name,
                    "quantity_data" => $respondentsDenda,
                    "nominal" => ((float)$denda->nominal / 100) * ((int)strtr($denda->from, $variables)),
                    "total" => $dataDenda,
                    "satuan" => "hari",
                    "kategori" => $denda->projectKota->kota->kota,
                    "diambil_dari" => $denda->take_from
                ];
            };

        }
    }

    public function count_denda_do_gift($denda, $team, $members, $variables)
    {
        $id = $denda->id;
        $respondentsDenda = Respondent::where('project_id', '=', $team->projectKota->project_id)
            ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            ->where("kota_id", $team->projectKota->kota_id)
            ->whereIn('srvyr', $members);

        if ($denda->take_from == '[respondent_do]') {
            $respondentsDenda = $respondentsDenda->where('respondent_gifts.status_pembayaran_id', 3)
                ->whereIn('status_qc_id', array(2, 3, 6, 9));
        }

        if ($denda->take_from == '[respondent]') {
            $respondentsDenda = $respondentsDenda->where('respondent_gifts.status_pembayaran_id', 3)
                ->whereIn('status_qc_id', array(5, 1, 0, 10));
        }

        $respondentsDenda = $respondentsDenda->count();

        $dataDenda = (int)$denda->nominal * $respondentsDenda;
        if(isset($this->dendaStatic[$id])) {
            $this->dendaStatic[$id]->total += $dataDenda;
        }  else {
            $this->dendaStatic[$id] = (object)[
                "nama_honor_denda" => $denda->variable->variable_name,
                "quantity_data" => $respondentsDenda,
                "nominal" => $denda->nominal,
                "total" => $dataDenda,
                "satuan" => "respondent",
                "kategori" => $denda->projectKota->kota->kota,
                "diambil_dari" => $denda->take_from
            ];
        };
    }

    public function count_denda_btf($denda, $team, $members, $variables)
    {
        $id = $denda->id;
        $respondentsDenda = Respondent::where('project_id', '=', $team->projectKota->project_id)
            ->join('respondent_btfs', 'respondent_btfs.respondent_id', '=', 'respondents.id')
            ->where("kota_id", $team->projectKota->kota_id)
            ->whereIn('srvyr', $members);

        if ($denda->take_from == '[respondent_do]') {
            $respondentsDenda = $respondentsDenda->whereIn('status_qc_id', array(2, 3, 6, 9));
        }

        if ($denda->take_from == '[respondent]') {
            $respondentsDenda = $respondentsDenda->whereIn('status_qc_id', array(5, 1, 0, 10));
        }

        $respondentsDenda = $respondentsDenda->count();
        $dataDenda = (int)$denda->nominal * $respondentsDenda;
        if(isset($this->dendaStatic[$id])) {
            $this->dendaStatic[$id]->total += $dataDenda;
        }  else {
            $this->dendaStatic[$id] = (object)[
                "nama_honor_denda" => $denda->variable->variable_name,
                "quantity_data" => $respondentsDenda,
                "nominal" => $denda->nominal,
                "total" => $dataDenda,
                "satuan" => "respondent",
                "kategori" => $denda->projectKota->kota->kota,
                "diambil_dari" => $denda->take_from
            ];
        };
    }

    public function count_denda_manual($denda, $team, $members, $variables)
    {
        $id = $denda->id;
        $respondentsDenda = Respondent::where('project_id', '=', $team->projectKota->project_id)
            ->join('denda_manual', 'denda_manual.id_subject', '=', 'respondents.id')
            ->where("kota_id", $team->projectKota->kota_id)
            ->whereIn('srvyr', $members);

        if ($denda->take_from == '[respondent_do]') {
            $respondentsDenda = $respondentsDenda->whereIn('status_qc_id', array(2, 3, 6, 9));
        }

        if ($denda->take_from == '[respondent]') {
            $respondentsDenda = $respondentsDenda->whereIn('status_qc_id', array(5, 1, 0, 10));
        }

        $respondentsDenda = $respondentsDenda->selectRaw("SUM(denda_manual.value) as sum_value_quantity")->first();
        $dataDenda = (int)$denda->nominal * $respondentsDenda->sum_value_quantity;
        if(isset($this->dendaStatic[$id])) {
            $this->dendaStatic[$id]->total += $dataDenda;
        }  else {
            $this->dendaStatic[$id] = (object)[
                "nama_honor_denda" => $denda->variable->variable_name,
                "quantity_data" => $respondentsDenda->sum_value_quantity,
                "nominal" => $denda->nominal,
                "total" => $dataDenda,
                "satuan" => $denda->take_from,
                "kategori" => $denda->projectKota->kota->kota,
                "diambil_dari" => $denda->take_from
            ];
        };
    }

    public function generatePaymentDate($codeBank): string
    {
        $tanggal = date('Y-m-d');

        $hour = mt_rand((int)date("h"),12);
        $time = $hour.":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);

        if ($codeBank != "CENAIDJA" && $hour > 12) {
            $tanggal = date("Y-m-d", strtotime($tanggal . " +1 day"));
            $time = mt_rand((int)8,12).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
        }
        return $tanggal . " " . $time.":00";
    }
}
