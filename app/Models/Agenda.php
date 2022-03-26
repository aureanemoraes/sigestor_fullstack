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
        'status',
        'exercicio_id'
    ];

    protected $appends = ['status_formatado'];

    public function getStatusFormatadoAttribute()
    {
        switch ($this->status) {
            case 'elaboracao':
                return 'Em elaboração';
                break;
            case 'aberta':
                return 'Aberta para planejamento das Unidades Gestoras e Administrativas';
                break;
            case 'analise':
                return 'Fechada para planejamento das Unidades Gestoras e Administrativas e aguardando aprovação da reitoria';
                break;
            case 'finalizada':
                return 'Finalizada';
                break;
        }
    }

    public function setStatusAttribute($value)
    {
        if(empty($value))
            $this->attributes['status'] = 'elaboracao';
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
