<?php

namespace App\Http\Controllers\Api\Paciente\Comorbidade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comorbidade;
use App\Models\Paciente;
use App\Api\ErrorMessage;
use App\Http\Requests\ComorbidadeRequest;

class ComorbidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($pacienteId)
    {
        try {
            $comorbidade = Comorbidade::where('paciente_id', $pacienteId)->first();

            if (!$comorbidade) {
                return response()->json(['message' => 'Paciente não possui comorbidade cadastrada.'], 204);
            }

            return response()->json($comorbidade);
        } catch (\Exception $e) {
            $message = new ErrorMessage($e->getMessage());
            return response()->json($message->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($pacienteId, ComorbidadeRequest $request)
    {
        try {
            $data = array_merge($request->all(), ['paciente_id' => $pacienteId]);

            $comorbidade = Comorbidade::where('paciente_id', $pacienteId)->first();
            if ($comorbidade) {
                $comorbidade->fill($data);
                $comorbidade->save();
            } else {
                $comorbidade = Comorbidade::create($data);
            }


            if ($request->has('doencas')) {
                $comorbidade->doencas()->sync($request->get('doencas'));
            }

            if ($request->has('orgaos')) {
                $comorbidade->orgaos()->sync($request->get('orgaos'));
            }

            if ($request->has('corticosteroides')) {
                $comorbidade->corticosteroides()->sync($request->get('corticosteroides'));
            }


            return response()->json($comorbidade, 201);
        } catch (\Exception $e) {
            $message = new ErrorMessage($e->getMessage());
            return response()->json($message->getMessage(), 500);
        }
    }
}
