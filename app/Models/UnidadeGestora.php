<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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

    protected $appends = ['nome_completo'];

    public static function getOptions() {
        if(Auth::check()) {
            switch(Auth::user()->perfil) {
                case 'institucional':
                    return UnidadeGestora::all();
                    break;
                case 'gestor':
                    $ids = Auth::user()->vinculos()->pluck('unidade_gestora_id')->toArray();
                    return UnidadeGestora::whereIn('id', $ids)->get();
                    break;
            }
        }
    }

    public function getNomeCompletoAttribute()
    {
        return "$this->sigla - $this->nome";
    }

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

    public function ploas_gestoras()
    {
        return $this->hasMany(PloaGestora::class);
    } 

    public function unidades_administrativas()
    {
        return $this->hasMany(UnidadeAdministrativa::class);
    } 
}
