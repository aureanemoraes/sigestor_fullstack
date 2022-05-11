<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empenho extends Model
{
    protected $table = 'empenhos';

    use HasFactory;

    protected $fillable = [
        'notas_fiscais',
        'certidao_credito_id'
    ];

    protected $appends = [
        'exercicio_id',
        'unidade_gestora_id'
    ];

    protected $casts = [
        'notas_fiscais' => 'array',
    ];


    public function getExercicioIdAttribute()
    {
        return $this->certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->exercicio_id;
    }

    public function getUnidadeGestoraIdAttribute()
    {
        return $this->certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->unidade_gestora_id;
    }
    
    public function certidao_credito()
    {
        return $this->belongsTo(CertidaoCredito::class);
    }
}
