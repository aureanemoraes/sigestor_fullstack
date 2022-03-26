<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'status',
        'agenda_id'
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
