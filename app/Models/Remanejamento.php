<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remanejamento extends Model
{
    use HasFactory;

    protected $table = 'remanejamentos';

    protected $fillable = [
        'qtd',
        'valor',
        'numero_oficio',
        'data',
        'despesa_remetente_id',
        'unidade_gestora_id',
        'instituicao_id',
    ];

   

    public function getStatusAttribute()
    {
        if(count($this->remanejamento_destinatarios) > 0) {
            return $this->valor == $this->remanejamento_destinatarios()->sum('valor');
        } 

        return false;
    }

    public function getValorDisponivelAttribute()
    {
        if(count($this->remanejamento_destinatarios) > 0) {
            $valor_disponivel = $this->valor - $this->remanejamento_destinatarios()->sum('valor');
            if($this->valor - $this->remanejamento_destinatarios()->sum('valor') > 0) {
                return $valor_disponivel;
            } else {
                return 0;
            }
        } else {
            return $this->valor;
        }
    }

    public function despesa_remetente()
    {
        return $this->belongsTo(Despesa::class, 'despesa_remetente_id', 'id');
    }

    public function remanejamento_destinatarios()
    {
        return $this->hasMany(RemanejamentoDestinatario::class);
    }
}
