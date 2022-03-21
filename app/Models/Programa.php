<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;

    protected $table = 'programas';

    protected $fillable = [
        'codigo',
        'nome',
        'fav'
    ];

    public function fontes()
    {
        return $this->belongsToMany(Fonte::class, 'fontes_programas', 'programa_id', 'fonte_id')->withPivot(
            'exercicio_id',
        );
    }
}