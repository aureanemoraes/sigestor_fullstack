<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    protected $table = 'despesas';

    protected $fillable = [
        'descricao',
        'valor',
        'valor_total',
        'tipo',
        'ploa_administrativa_id',
        'centro_custo_id',
        'natureza_despesa_id',
        'subnatureza_despesa_id',
        'meta_id',
        'fields',
        'despesa_modelo_id'
    ];

    protected $casts = [
        'fields' => 'array'
    ];

    // protected $appends = ['fonte', 'acao', 'valor_disponivel', 'possui_solicitacao_credito_pendente', 'valor_recebido', 'exercicio_id'];

    public function getRemanejamentoIdAttribute()
    {
        if(count($this->remanejamentos) > 0) {
            foreach($this->remanejamentos as $remanejamento) {
                if(count($remanejamento->remanejamento_destinatarios) > 0) {
                    $valor_disponivel = $remanejamento->valor - $remanejamento->remanejamento_destinatarios()->sum('valor');
                    if($valor_disponivel > 0) {
                        return $remanejamento->id;
                    } else {
                        return null;
                    }
                } else {
                    return $remanejamento->id;
                }
            }
        }

        return null;
    }

    public function getFonteAttribute()
    {
        return $this->ploa_administrativa->ploa_gestora->ploa->fonte_tipo->codigo;
    }

    public function getAcaoAttribute()
    {
        return $this->ploa_administrativa->ploa_gestora->ploa->acao_tipo->nome_completo;
    }

    public function getExercicioIdAttribute()
    {
        return $this->ploa_administrativa->ploa_gestora->ploa->exercicio_id;
    }

    public function getValorDisponivelAttribute()
    {
        if(count($this->creditos_planejados) > 0) {
            $valor_recebido = $this->creditos_planejados->where('unidade_gestora', 'deferido')->where('instituicao', 'deferido')->sum('valor_solicitado');
            return $this->valor_total - $valor_recebido;
        } else 
            return $this->valor_total;
    }

    public function getValorRecebidoAttribute()
    {
        if(count($this->creditos_planejados) > 0) {
            $valor_recebido = $this->creditos_planejados->where('unidade_gestora', 'deferido')->where('instituicao', 'deferido')->sum('valor_solicitado');
            return $valor_recebido;
        } else 
            return 0;
    }

    public function getPossuiSolicitacaoCreditoPendenteAttribute()
    {
        if(count($this->creditos_planejados) > 0) {
            return $this->creditos_planejados()->where('unidade_gestora', 'pendente')->where('instituicao', 'pendente')->exists();
        } else 
            return false;
    }

    public function setValorTotalAttribute($valor)
    {
        $fields = $this->fields;
        if(isset($fields)) {
            if(count($fields) > 0) {
                foreach($fields as $key => $value) {
                    if(isset($value)) {
                        if($valor > 0 && $value['valor'] > 1) 
                            $valor += (floatval($this->valor) * floatval($value['valor']));
                        else
                            $valor = floatval($this->valor) * floatval($value['valor']);
                    }
                }
                $this->attributes['valor_total'] = $valor;
            }
            else {
                $this->attributes['valor_total'] = $this->valor;
            }
        } else {
            $this->attributes['valor_total'] = $this->valor;
        }
    }

    public function ploa_administrativa()
    {
        return $this->belongsTo(PloaAdministrativa::class);
    } 

    public function centro_custo()
    {
        return $this->belongsTo(CentroCusto::class);
    } 

    public function natureza_despesa()
    {
        return $this->belongsTo(NaturezaDespesa::class);
    } 

    public function subnatureza_despesa()
    {
        return $this->belongsTo(SubnaturezaDespesa::class);
    } 

    public function meta()
    {
        return $this->belongsTo(Meta::class);
    } 

    public function creditos_planejados()
    {
        return $this->hasMany(CreditoPlanejado::class);
    } 

    public function remanejamentos()
    {
        return $this->hasMany(Remanejamento::class, 'despesa_remetente_id', 'id');
    } 
}
