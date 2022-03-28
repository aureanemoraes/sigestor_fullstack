<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agendas';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'exercicio_id'
    ];

    protected $appends = ['status'];

    public function getStatusAttribute()
    {
        $data_valida = date('Y-m-y') <= $this->data_fim  ;

        if($data_valida) {
            if(count($this->eventos) > 0) {
                if($this->eventos->last()->data_fim > date('Y-m-y'))
                    return 'Aberta para planejamento';
                else
                    return 'Em análise/aprovação';
            }
            else 
                return 'Em elaboração';
        }
        else 
            return 'Finalizada';
    }

    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
