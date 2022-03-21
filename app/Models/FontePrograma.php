<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FontePrograma extends Model
{
    use HasFactory;

    protected $table = 'fontes_programas';

    protected $fillable = [
        'fonte_id',
        'programa_id',
        'exercicio_id'
    ];

    protected $with = [
        'fonte:id,fonte_tipo_id',
        'programa:id,nome',
        'exercicio:id,nome'
    ];

    public function fonte()
    {
        return $this->belongsTo(Fonte::class);
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class);
    }

    public function exercicio()
    {
        return $this->belongsTo(exercicio::class);
    }
}
