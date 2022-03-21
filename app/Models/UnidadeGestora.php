<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadeGestora extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'unidades_gestoras';

    protected $fillable = [
        'nome',
        'sigla',
        'cnpj',
        'uasg',
        'logradouro',
        'numero',
        'bairro',
        'complemento',
        'logs',
        'instituicao_id'
    ];

    protected $casts = [
        'logs' => 'array'
    ];

    protected $with = [
        'instituicao:id,nome'
    ];

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = strtoupper($value);
    }

    public function diretor_geral()
    {
        return $this->belongsTo(Pessoa::class, 'diretor_geral_id', 'id');
    } 

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    } 
}
