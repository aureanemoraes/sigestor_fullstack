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
        'solicitado',
        'valor_solicitado',
        'comentarios'
    ];

    protected $appends = [
        'numero_solicitacao', // valor planejado na despesa
        'status_gestora',
        'status_instituicao'
    ];

    public function getNumeroSolicitacaoAttribute()
    {
        return $this->despesa->ploa_administrativa->unidade_administrativa->uasg . $this->despesa->ploa_administrativa->ploa_gestora->ploa->exercicio->nome . $this->id;
    }

    public function getStatusGestoraAttribute()
    {
        switch($this->unidade_gestora) {
            case 'pendente':
                return ['class' => 'bg-secondary', 'texto' => 'Pendente por Unidade Gestora'];
                break;
            case 'indeferido':
                return ['class' => 'bg-danger', 'texto' => 'Indeferido por Unidade Gestora'];
                break;
            case 'deferido':
                return ['class' => 'bg-success', 'texto' => 'Deferido por Unidade Gestora'];
                break;
        }
    }

    public function getStatusInstituicaoAttribute()
    {
        switch($this->instituicao) {
            case 'pendente':
                return ['class' => 'bg-secondary', 'texto' => 'Pendente por Instituição'];
                break;
            case 'indeferido':
                return ['class' => 'bg-danger', 'texto' => 'Indeferido por Instituição'];
                break;
            case 'deferido':
                return ['class' => 'bg-success', 'texto' => 'Deferido por Instituição'];
                break;
        }
    }

    public function despesa()
    {
        return $this->belongsTo(Despesa::class);
    } 
}