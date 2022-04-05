<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DespesaModelo extends Model
{
    use HasFactory;

    protected $table = 'despesas_modelos';

    protected $fillable = [
        'descricao',
        'valor',
        'valor_total',
        'tipo',
        'centro_custo_id',
        'natureza_despesa_id',
        'subnatureza_despesa_id',
        'meta_id',
        'fields'
    ];

    protected $casts = [
        'fields' => 'array'
    ];

    public function setValorTotalAttribute($valor)
    {
        $fields = $this->fields;
        if(isset($fields)) {
            if(count($fields) > 0) {
                foreach($fields as $key => $value) {
                    if(isset($value)) {
                        if($valor > 0) 
                            $valor += ($this->valor * floatval($value['valor']));
                        else
                            $valor = $this->valor * floatval($value['valor']);
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
}
