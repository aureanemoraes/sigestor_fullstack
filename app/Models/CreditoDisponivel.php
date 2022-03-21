<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditoDisponivel extends Model
{
    use HasFactory;

    protected $table = 'creditos_disponiveis';

    protected $fillable = [
        'descricao',
        'valor_solicitado',
        'valor_disponivel',
        'despesa_id',
        'unidade_administrativa_id'
    ];

    // protected $appends = [
    //     'valor_solicitado' // valor planejado na despesa
    // ];

    protected $with = [
        'despesa:id,descricao', 
        'unidade_administrativa:id,nome'
    ];

   
    public function despesa()
    {
        return $this->belongsTo(Despesa::class);
    } 

    public function unidade_administrativa()
    {
        return $this->belongsTo(UnidadeAdministrativa::class);
    } 

    // public function getValorSolicitadoAttribute($value) {
    //     if(isset($this->attributes['despesa_id'])) {
    //         $valor_solicitado = Despesa::find($this->attributes['despesa_id'])->valor_total;
    //         return floatval($valor_solicitado);
    //     }
    // }
}
