<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuporteRespiratorioStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '*.id' => 'nullable|integer|exists:suportes_respiratorios,id',
            '*.tipo_suporte_id' => 'required|integer|exists:tipos_suportes_respiratorios,id',
            '*.parametro' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            '*.data_inicio' => 'exclude_if:*.tipo_suporte_id,10,11|required|date',
            '*.menos_24h_vmi' => 'nullable|bool',
            '*.data_pronacao' => 'exclude_unless:*.tipo_suporte_id,10|required|date',
            '*.quantidade_horas' => 'exclude_unless:*.tipo_suporte_id,10|nullable|regex:/^\d+(\.\d{1,2})?$/',
            '*.data_inclusao_desmame' => 'exclude_unless:*.tipo_suporte_id,11|required'
        ];
    }
}
