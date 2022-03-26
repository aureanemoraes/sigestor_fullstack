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

    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }
}
