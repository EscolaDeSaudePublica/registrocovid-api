<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDesfecho extends Model
{
    const TIPO_ALTA_HOSPITALAR = 1;
    const TIPO_TRANSFERENCIA_SERVICO = 2;
    const TIPO_OBITO = 3;

    protected $hidden = ['created_at', 'updated_at'];
}
