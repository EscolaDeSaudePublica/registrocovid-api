<?php

namespace App\Http\Controllers\Api\Paciente\ExamesLaboratoriais;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExameRtPcrRequest;
use App\Models\ExameRtPcr;
use Illuminate\Http\Request;

class ExamesLaboratoriaisController extends Controller
{
    public function store(ExameRtPcrRequest $request, $pacienteId)
    {
        $exameRtPcr = ExameRtPcr::create(array_merge(
            $request->except(['data_realizacao', 'resultado']),
            [
                'paciente_id' => $pacienteId
            ]
        ));

        $exameRtPcr->criarExameTesteRapido($request->only(['data_realizacao', 'resultado']), $pacienteId);

        return response()->json([
            "message" => "Exames laboratóriais específicos cadastrado com sucesso",
        ]);
    }
}