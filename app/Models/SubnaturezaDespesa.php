<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubnaturezaDespesa extends Model
{
    use HasFactory;
    

    protected $table = 'subnaturezas_despesas';

    protected $fillable = [
        'nome',
        'codigo',
        'natureza_despesa_id',
        'fields'
    ];

    protected $casts = [
        'fields' => 'array',
        'valores' => 'array'
    ];

    public function getValoresAttribute()
    {
        $valores['total_custo_fixo'] = $this->despesas()->where('tipo', 'despesa_fixa')->sum('valor_total');
        $valores['total_custo_variavel'] = $this->despesas()->where('tipo', 'despesa_variavel')->sum('valor_total');
        $valores['total'] = $valores['total_custo_fixo'] + $valores['total_custo_variavel']; 

        return $valores;
    }

    public function natureza_despesa() 
    {
        return $this->belongsTo(NaturezaDespesa::class);
    }

    public function despesas()
    {
        return $this->hasMany(Despesa::class, 'subnatureza_despesa_id', 'id');
    }
}
