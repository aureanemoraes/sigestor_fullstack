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
        'plano_estrategico_id',
    ];

    public function plano_estrategico()
    {
        return $this->belongsTo(PlanoEstrategico::class);
    }
}
