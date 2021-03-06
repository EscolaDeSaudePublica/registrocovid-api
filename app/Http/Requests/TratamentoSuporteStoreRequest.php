<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TratamentoSuporteStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'data_inicio' => 'required|date',
            'data_termino' => 'required|date',
            'motivo_hemodialise' => 'nullable|string',
            'frequencia_hemodialise' => 'nullable|string'
        ];
    }
}
