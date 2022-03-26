<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;

    protected $table = 'metas';

    protected $fillable = [
        'nome',
        'descricao', // dar mais bolsas para alunos carentes
        'tipo', // porcentagem, valor, maior_que, menor_que ,
        'tipo_dado',
        'valor_inicial', //
        'valor_final', // 100%
        'valor_atingido', // 2%
        'objetivo_id',
        'plano_acao_id'
    ];

    protected $appends = ['porcentagem_atual'];

    public function getPorcentagemAtualAttribute()
    {
        $valor_inicial = isset($this->attributes['valor_inicial']) ? $this->attributes['valor_inicial'] : 0;

        if(isset($this->valor_atingido)) {
            $porcentagem_atual = ($this->valor_atingido * 100)/$this->valor_final;
            return $porcentagem_atual . '%';
        } elseif($valor_inicial > 0) {
            $porcentagem_atual = ($valor_inicial * 100)/$this->valor_final;
            return $porcentagem_atual . '%';
        } else {
            return null;
        }
    }

    public function getValorAtingidoAttribute($value)
    {
        if(is_null($value))
            $value = !is_null($this->valor_inicial) ? $this->valor_inicial : 0;

        $value += $this->checkins()->sum('valor');
   
        return $value;
    }

    public function objetivo()
    {
        return $this->belongsTo(Objetivo::class);
    } 

    public function plano_acao()
    {
        return $this->belongsTo(PlanoAcao::class);
    } 

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function responsaveis()
    {
        return $this->belongsToMany(UnidadeGestora::class, 'metas_responsaveis', 'meta_id', 'unidade_gestora_id');
    }
}
