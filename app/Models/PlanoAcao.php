<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoAcao extends Model
{
    use HasFactory;

    protected $table = 'planos_acoes';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'plano_estrategico_id',
        'instituicao_id'
    ];

    protected $casts = [
        'data_inicio' => 'datetime:Y-m-d',
        'data_fim' => 'datetime:Y-m-d',
    ];
}
