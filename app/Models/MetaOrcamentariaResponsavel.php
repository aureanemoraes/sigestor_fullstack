<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaOrcamentariaResponsavel extends Model
{
    use HasFactory;

    protected $table = 'metas_orcamentarias_responsaveis';

    protected $fillable = [
        'qtd_estimada',
        'qtd_alcancada',
        'meta_orcamentaria_id',
        'unidade_gestora_id',
        'exercicio_id'
    ];

    public function meta_orcamentaria()
    {
        return $this->belongsTo(MetaOrcamentaria::class);
    } 

    public function unidade_gestora()
    {
        return $this->belongsTo(UnidadeGestora::class);
    }

    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }
}
