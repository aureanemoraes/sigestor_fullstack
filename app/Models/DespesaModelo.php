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
}
