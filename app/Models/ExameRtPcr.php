<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExameRtPcr extends Model
{
    protected $table = 'exames_rt_pcr';

    protected $fillable = [
        'paciente_id',
        'data_coleta',
        'sitio_tipo_id',
        'data_resultado',
        'rt_pcr_resultado_id'
    ];

    protected $with = [
        'sitiosTipos',
        'rtPcrResultados'
    ];

    protected $hidden = ['created_at', 'updated_at','paciente_id'];

    public function sitiosTipos()
    {
        return $this->hasOne(TipoSitio::class, 'id', 'sitio_tipo_id');
    }

    public function rtPcrResultados()
    {
        return $this->hasOne(RtPcrResultado::class, 'id', 'rt_pcr_resultado_id');
    }
}
