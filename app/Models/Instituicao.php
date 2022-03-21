<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Instituicao extends Model
{
    use HasFactory;
    

    protected $table = 'instituicoes';

    protected $fillable = [
        'nome',
        'sigla',
        'cnpj',
        'uasg',
        'logradouro',
        'numero',
        'bairro',
        'complemento'
    ];

    public static function getOpcoes() {
        $opcoes = Instituicao::select('id', 'nome')->get()->toArray();

        return $opcoes;
    }

    // Acessors

    // Mutators

    // Exercícios
    public function exercicios()
    {
        return $this->hasMany(Exercicio::class);
    }

    public function unidades_gestoras()
    {
        return $this->hasMany(UnidadeGestora::class);
    }

    public function unidades_administrativas()
    {
        return $this->hasMany(UnidadeAdministrativa::class);
    }
}
