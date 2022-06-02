<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class UnidadeAdministrativa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'unidades_administrativas';

    protected $fillable = [
        'nome',
        'sigla',
        'uasg',
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

    protected $appends = ['nome_completo'];

    public static function getOptions() {
        if(Auth::check()) {
            switch(Auth::user()->perfil) {
                case 'institucional':
                    return UnidadeAdministrativa::all();
                    break;
                case 'gestor':
                    $ids = Auth::user()->vinculos()->pluck('unidade_gestora_id')->toArray();
                    return UnidadeAdministrativa::whereIn('unidade_gestora_id', $ids)->get();
                    break;
                case 'administrativo':
                    $ids = Auth::user()->vinculos()->pluck('unidade_administrativa_id')->toArray();
                    return UnidadeAdministrativa::whereIn('id', $ids)->get();
                    break;
                default:
                    return [];
            }
        }
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = strtoupper($value);
    }

    public function getNomeCompletoAttribute()
    {
        return "$this->sigla - $this->nome";
    }

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    } 

    public function unidade_gestora()
    {
        return $this->belongsTo(UnidadeGestora::class);
    } 

    public function ploas_administrativas()
    {
        return $this->hasMany(PloaAdministrativa::class);
    } 
}
