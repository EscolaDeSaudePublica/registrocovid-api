<?php

namespace App\Http\Controllers\Api\Paciente;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{
    private $paciente;

    public function __construct(Paciente $paciente)
    {
        $this->paciente = $paciente;
    }

    public function store(Request $request)
    {
        try {
            $dataValidated = Validator::make($request->all(), [
                'prontuario' => 'required|unique:pacientes',
                'data_internacao' => 'required|date'
            ]);

            if ($dataValidated->fails()) {
                return response()->json($dataValidated->errors());
            }

            $pacienteInstance = $this->paciente->fill(array_merge(
                $request->post(),
                [
                    'coletador_id' => auth()->user()->id
                ]
            ));

            $pacienteInstance->save();

            return response()->json(['message' => 'Paciente criado com sucesso'], 201);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

}
