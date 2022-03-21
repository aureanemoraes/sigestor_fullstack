<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadeAdministrativa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'unidades_administrativas';

    protected $fillable = [
        'nome',
        'sigla',
        'ugr',
        'logs',
        'instituicao_id',
        'unidade_gestora_id'
    ];

    protected $casts = [
        'logs' => 'array'
    ];

    protected $with = [
        'instituicao:id,nome',
        'unidade_gestora:id,nome'
    ];

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = strtoupper($value);
    }

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    } 

    public function unidade_gestora()
    {
        return $this->belongsTo(UnidadeGestora::class);
    } 
}
