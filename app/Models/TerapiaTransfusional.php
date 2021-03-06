<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerapiaTransfusional extends Model
{
    protected $table = 'transfusao_ocorrencias';

    protected $fillable = [
        'paciente_id',
        'tipo_transfusao_id',
        'data_transfusao',
        'volume_transfusao'
    ];

    protected $hidden = ['created_at', 'updated_at', 'tipo_transfusao_id', 'paciente_id'];

    protected $with = [
        'tiposTransfusao'
    ];

    public function tiposTransfusao()
    {
        return $this->hasOne(TipoTransfusao::class, 'id', 'tipo_transfusao_id');
    }
}
