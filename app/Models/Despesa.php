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
        'qtd',
        'qtd_pessoas',
        'tipo',
        'ploa_administrativa_id',
        'centro_custo_id',
        'natureza_despesa_id',
        'subnatureza_despesa_id',
        'unidade_administrativa_id',
        'meta_id',
        'exercicio_id'
    ];

 
    // public function setValorTotalAttribute($value)
    // {
    //     if(isset($value)) {
    //         $this->attributes['valor_total'] = $value;
    //         if(isset($this->attributes['qtd'])) {
    //             $this->attributes['valor_total'] = $this->attributes['valor_total']  * $this->attributes['qtd'];
    //             if(isset($this->attributes['qtd_pessoas'])) {
    //                 $this->attributes['valor_total'] = $this->attributes['valor_total'] * $this->attributes['qtd_pessoas'];
    //             }
    //         }
    //         $this->attributes['valor_total'];
    //     } else {
    //         $this->attributes['valor_total'];
    //     }
    // }

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

    public function unidade_administrativa()
    {
        return $this->belongsTo(UnidadeAdministrativa::class);
    } 

    public function execicio()
    {
        return $this->belongsTo(Exercicio::class);
    } 

    public function meta()
    {
        return $this->belongsTo(Meta::class);
    } 
}
