<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditoPlanejado extends Model
{
    use HasFactory;

    protected $table = 'creditos_planejados';

    protected $fillable = [
        'codigo_processo',
        'despesa_id',
        'unidade_gestora',
        'instituicao',
        'solicitado'
    ];

    protected $appends = [
        'numero_solicitacao' // valor planejado na despesa
    ];

    public function getNumeroSolicitacaoAttribute()
    {
        return $this->despesa->ploa_administrativa->unidade_administrativa->uasg . $this->despesa->ploa_administrativa->ploa_gestora->ploa->exercicio->nome . $this->id;
    }

    public function despesa()
    {
        return $this->belongsTo(Despesa::class);
    } 
}