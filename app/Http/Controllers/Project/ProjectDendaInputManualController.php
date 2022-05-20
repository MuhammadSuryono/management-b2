<?php

namespace App\Http\Controllers\Project;

use App\DendaManual;
use App\Http\Controllers\Controller;
use App\NominalDenda;
use App\Project;
use App\Project_kota;
use App\Respondent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectDendaInputManualController extends Controller
{
    protected $request;

    protected $headerTable = '';
    protected $bodyTable = '';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index($projectId)
    {
        $project = Project::find($projectId);
        $dendaVariable = [];
        $headerTable = "";
        $bodyTable = "";
        $actionSave = "";
        if ($this->request->has('projectKotaId')) {
            $dendaVariable = NominalDenda::where('selection_id', $this->request->projectKotaId)
                ->where('type_variable', 'input_manual')
                ->where('type', 'project_kota')->get();

            if ($this->request->has('variable')) {
                $variable = NominalDenda::find($this->request->variable);
                $methode = $this->methodeInputManualData($projectId, $variable)[$variable->take_from];
                call_user_func_array([$this, $methode['function']], $methode['parameters']);
                $actionSave = route("input_manual_denda_page", [$projectId, "projectKotaId" => $this->request->projectKotaId, "variable" => $this->request->variable, "takeFrom" => $variable->take_from]);
                $headerTable = $this->headerTable;
                $bodyTable = $this->bodyTable;
            }
        }
        return view('projects.projects.input-manual', compact('project','dendaVariable', 'projectId', 'headerTable', 'bodyTable', 'actionSave'));
    }

    public function saveDendaManual()
    {
        DB::beginTransaction();
        try {
            $dataInsert = [];
            foreach ($this->request->valueQuantity as $key => $val) {
                if ($val != "0") {
                    $denda = DendaManual::where('id_subject',$this->request->id[$key])
                        ->where('id_nominal_denda', $this->request->variable)
                        ->where('type',$this->request->takeFrom)->first();
                    if (!$denda) {
                        $dataInsert[] = [
                            "id_subject" => $this->request->id[$key],
                            "id_nominal_denda" => $this->request->variable,
                            "type" => $this->request->takeFrom,
                            "value" => $val,
                        ];
                    } else {
                        $denda->value = $val;
                        $denda->save();
                    }
                }
            }
            DendaManual::insert($dataInsert);
            DB::commit();
            return redirect()->back()->with(['success' => "Success save data"]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function methodeInputManualData($projectId, $variable): array
    {
        return [
            "[respondent_do]" => [
                'function' => 'respondentDo',
                'parameters' => [$projectId, $variable]
            ],
            "[respondent]" => [
                'function' => 'respondent',
                'parameters' => [$projectId, $variable]
            ],
            "[respondent_btf]" => [
                'function' => 'respondent_btf',
                'parameters' => [$projectId, $variable]
            ],
        ];
    }

    public function respondentDo($projectId, $variable)
    {
        $this->headerTable = '<thead><tr><th>No</th><th>Nama Respondent</th><th>Kota</th><th>Value Quantity <br/>'.$variable->nominal.'/'.$variable->take_from.'</th></tr></thead>';

        $projectKota = Project_kota::find($this->request->projectKotaId);
        $respondentDo = Respondent::where('project_id', $projectId)
            ->whereIn('status_qc_id', array(2, 3, 6, 9))
            ->where('kota_id', $projectKota->kota->id)->get();

        $this->bodyTable = '<tbody>';
        $no = 0;
        foreach ($respondentDo as $key => $respondent) {
            $no++;
            $value = $respondent->dendaManual->value ?? 0;
            $this->bodyTable .= '<tr>
                                    <td>'. $no .'</td>
                                    <td>'. $respondent->respname .'</td>
                                    <td>'. $respondent->kota->kota .'</td>
                                    <td><input name="valueQuantity[]" class="form-control" value="'.$value.'"><input name="id[]" class="form-control" value="'.$respondent->id.'" type="hidden"></td>
                               </tr>';
        }

        $this->bodyTable .= '</tbody>';
    }

    public function respondent($projectId, $variable)
    {
        $this->headerTable = '<thead><tr><th>No</th><th>Nama Respondent</th><th>Kota</th><th>Value Quantity <br/>'.$variable->nominal.'/'.$variable->take_from.'</th></tr></thead>';

        $projectKota = Project_kota::find($this->request->projectKotaId);
        $respondentDo = Respondent::where('project_id', $projectId)
            ->whereIn('status_qc_id', array(5, 1, 0, 10))
            ->where('kota_id', $projectKota->kota->id)->get();

        $this->bodyTable = '<tbody>';
        $no = 0;
        foreach ($respondentDo as $key => $respondent) {
            $no++;
            $value = $respondent->dendaManual->value ?? 0;
            $this->bodyTable .= '<tr>
                                    <td>'. $no .'</td>
                                    <td>'. $respondent->respname .'</td>
                                    <td>'. $respondent->kota->kota .'</td>
                                    <td><input name="valueQuantity[]" class="form-control" value="'.$value.'"><input name="id[]" class="form-control" value="'.$respondent->id.'" type="hidden"></td>
                               </tr>';
        }

        $this->bodyTable .= '</tbody>';
    }

    public function respondent_btf($projectId, $variable)
    {
        $this->headerTable = '<thead><tr><th>No</th><th>Nama Respondent</th><th>Kota</th><th>Value Quantity <br/>'.$variable->nominal.'/'.$variable->take_from.'</th></tr></thead>';

        $projectKota = Project_kota::find($this->request->projectKotaId);
        $respondentDo = Respondent::where('project_id', $projectId)
            ->join('respondent_btfs', 'respondent_btfs.respondent_id', '=', 'respondents.id')
            ->where('kota_id', $projectKota->kota->id)->get();

        $this->bodyTable = '<tbody>';
        $no = 0;
        foreach ($respondentDo as $key => $respondent) {
            $no++;
            $value = $respondent->dendaManual->value ?? 0;
            $this->bodyTable .= '<tr>
                                    <td>'. $no .'</td>
                                    <td>'. $respondent->respname .'</td>
                                    <td>'. $respondent->kota->kota .'</td>
                                    <td><input name="valueQuantity[]" class="form-control" value="'.$value.'"><input name="id[]" class="form-control" value="'.$respondent->id.'" type="hidden"></td>
                               </tr>';
        }

        $this->bodyTable .= '</tbody>';
    }
}
