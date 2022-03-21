<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FonteAcao extends Model
{
    use HasFactory;

    protected $table = 'fontes_acoes';

    protected $fillable = [
        'fonte_id',
        'acao_id',
        'exercicio_id',
        'valor',
        'instituicao_id',
        'unidade_gestora_id',
        'unidade_administrativa_id'
    ];

    protected $with = [
        'exercicio:id,nome'
    ];

    public function fonte()
    {
        return $this->belongsTo(Fonte::class);
    }

    public function acao_tipo()
    {
        return $this->belongsTo(AcaoTipo::class);
    }
    
    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    }

    public function unidade_gestora()
    {
        return $this->belongsTo(UnidadeGestora::class);
    }

    public function unidade_administrativa()
    {
        return $this->belongsTo(UnidadeAdministrativa::class);
    }

    public function despesas()
    {
        return $this->hasMany(Despesa::class);
    }
}
