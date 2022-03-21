<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoEstrategico extends Model
{
    use HasFactory;

    protected $table = 'planos_estrategicos';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'instituicao_id'
    ];

    protected $casts = [
        'data_inicio' => 'datetime:Y-m-d',
        'data_fim' => 'datetime:Y-m-d',
    ];
}
