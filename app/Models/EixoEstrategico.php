<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EixoEstrategico extends Model
{
    use HasFactory;

    protected $table = 'eixos_estrategicos';

    protected $fillable = [
        'nome',
        'data_fim',
        'plano_estrategico_id',
        'instituicao_id'
    ];
}
