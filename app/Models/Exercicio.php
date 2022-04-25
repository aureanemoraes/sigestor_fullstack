<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Exercicio extends Model
{
    use HasFactory;
    

    protected $table = 'exercicios';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'instituicao_id'
    ];

    protected $casts = [
        'data_inicio' => 'datetime:Y-m-d',
        'data_fim' => 'datetime:Y-m-d',
    ];

    protected $with = [
        'instituicao:id,nome'
    ];

    public function getStatusAttribute()
    {
        if($this->data_fim <= date('Y-m-d'))
            return 'FINALIZADA';
        else
            return 'EM VIGÊNCIA';

    }

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    }

    public function ploas()
    {
        return $this->hasMany(Ploa::class);
    }
}
