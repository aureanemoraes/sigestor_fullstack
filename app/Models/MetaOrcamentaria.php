<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaOrcamentaria extends Model
{
    use HasFactory;

    protected $table = 'metas_orcamentarias';

    protected $fillable = [
        'nome',
        'qtd_estimada',
        'qtd_alcancada',
        'acao_tipo_id',
        'natureza_despesa_id',
        'fields',
    ];

    protected $casts = [
        'fields' => 'array'
    ];

    public function getQtdEstimadaAttribute($value)
    {
        if(!isset($value)) {
            if(isset($this->natureza_despesa_id)) {
                $qtd_estimada = Despesa::where('natureza_despesa_id', $this->natureza_despesa_id)->sum('valor_total');
                return $qtd_estimada;
            }
        } else {
            return $value;
        }
    }

    public function getQtdAlcancadaAttribute($value)
    {
        if(!isset($value)) {
            if(isset($this->natureza_despesa_id)) {
                $empenho = Empenho::whereHas(
                    'credito_disponivel', function ($query) {
                        $query->whereHas(
                            'despesa', function ($query2) {
                            $query2->where('natureza_despesa_id', $this->natureza_despesa_id);
                        });
                    }
                )->first();
                
                if(isset($empenho)) $qtd_alcancada = $empenho->valor_empenhado;
                else $qtd_alcancada = 0;
                return $qtd_alcancada;
            }
        } else {
            return $value;
        }
    }

    public function natureza_despesa()
    {
        return $this->belongsTo(NaturezaDespesa::class);
    } 

    public function acao()
    {
        return $this->belongsTo(Acao::class);
    } 

}
