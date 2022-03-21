<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empenho extends Model
{
    protected $table = 'empenhos';

    use HasFactory;

    protected $fillable = [
        'valor_empenhado',
        'data_empenho',
        'credito_disponivel_id',
        'unidade_administrativa_id'
    ];

    protected $casts = [
        'data_empenho' => 'datetime:Y-m-d',
    ];

    public function unidade_administrativa()
    {
        return $this->belongsTo(UnidadeAdministrativa::class);
    }

    public function credito_disponivel()
    {
        return $this->belongsTo(CreditoDisponivel::class);
    }
}
