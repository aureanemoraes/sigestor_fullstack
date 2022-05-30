<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    protected static function boot()
    {
        parent::boot();
     
        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

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
