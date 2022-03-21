<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acao extends Model
{
    use HasFactory;

    protected $table = 'acoes';

    protected $fillable = [
        'acao_tipo_id',
        'exercicio_id',
        'instituicao_id',
        'fav'
    ];

    protected $with = [
        'acao_tipo:id,codigo,nome',
        'exercicio:id,nome'
    ];

    protected $casts = [
        'valor_total'
    ];

    public function scopeWithAndWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
                     ->with([$relation => $constraint]);
    }

    public function getValorTotalAttribute() {
        return isset($this->attributes['valor_total']) ? $this->attributes['valor_total'] : 0;
    }

    public function acao_tipo()
    {
        return $this->belongsTo(AcaoTipo::class);
    }
    
    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }

    public function fontes()
    {
        return $this->belongsToMany(Fonte::class, 'fontes_acoes', 'acao_id', 'fonte_id')->withPivot(
            'exercicio_id',
            'valor',
            'instituicao_id',
            'unidade_gestora_id',
            'unidade_administrativa_id'
        );
    }
}
