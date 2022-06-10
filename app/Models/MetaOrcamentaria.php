<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class MetaOrcamentaria extends Model
{
    use HasFactory;

    protected $table = 'metas_orcamentarias';

    protected $fillable = [
        'nome',
        'acao_tipo_id',
        'natureza_despesa_id',
        'field',
    ];

    // protected $appends = ['field_text'];

    public function getFieldAttribute($value) {
        if(!is_null($value)) {
            if($value == 'valor_total') {
                return ['slug' => $value,'label' => "Valor total"];
            } else if ($value == 'valor') {
                return ['slug' => $value,'label' => "Valor unitário"];
            } else {
                $field = Arr::first($this->natureza_despesa->fields, function ($arrValue, $key) use($value) {
                    return $arrValue['slug'] == $value;
                });
                return $field;
            }
        }

        return ['slug' => null,'label' => null];
    }



    // public function getQtdEstimadaAttribute($value)
    // {
    //     return $value;

        // if(!isset($value)) {
        //     if(isset($this->natureza_despesa_id)) {
        //         $qtd_estimada = Despesa::where('natureza_despesa_id', $this->natureza_despesa_id)->sum('valor_total');
        //         return $qtd_estimada;
        //     }
        // } else {
        //     return $value;
        // }
    // }

    // public function getQtdAlcancadaAttribute($value)
    // {
    //     return $value;
        // if(!isset($value)) {
        //     if(isset($this->natureza_despesa_id)) {
        //         $empenho = Empenho::whereHas(
        //             'credito_disponivel', function ($query) {
        //                 $query->whereHas(
        //                     'despesa', function ($query2) {
        //                     $query2->where('natureza_despesa_id', $this->natureza_despesa_id);
        //                 });
        //             }
        //         )->first();
                
        //         if(isset($empenho)) $qtd_alcancada = $empenho->valor_empenhado;
        //         else $qtd_alcancada = 0;
        //         return $qtd_alcancada;
        //     }
        // } else {
        //     return $value;
        // }
    // }

    public function natureza_despesa()
    {
        return $this->belongsTo(NaturezaDespesa::class);
    } 

    public function acao_tipo()
    {
        return $this->belongsTo(AcaoTipo::class);
    } 

    public function responsavel()
    {
        return $this->hasOne(MetaOrcamentariaResponsavel::class);
    }
}
