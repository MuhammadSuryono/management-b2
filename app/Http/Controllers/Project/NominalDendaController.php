<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\NominalDenda;
use Illuminate\Http\Request;

class NominalDendaController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function showNominalDenda($projectId, $type, $selectionId)
    {
        $nominalDenda = NominalDenda::with(["variable"])->where('project_id', $projectId)->where('type', $type)->where("selection_id", $selectionId)->get();
        return response()->json($nominalDenda);
    }

    public function storeNominalDenda()
    {
        $nominalDenda = new NominalDenda();
        $nominalDenda->project_id = $this->request->project_id;
        $nominalDenda->variable_id = $this->request->variable_id;
        $nominalDenda->nominal = $this->request->nominal;
        $nominalDenda->selection_id = $this->request->selection_id;
        $nominalDenda->type = $this->request->type;
        $isSaved = $nominalDenda->save();
        return response()->json(["success" => $isSaved]);
    }

    public function updateNominalDenda($id)
    {
        $nominalDenda = NominalDenda::find($id);
        $nominalDenda->nominal = $this->request->nominal;
        $nominalDenda->save();
        return response()->json($nominalDenda);
    }

    public function deleteNominalDenda($id)
    {
        $nominalDenda = NominalDenda::find($id);
        $nominalDenda->delete();
        return response()->json($nominalDenda);
    }
}