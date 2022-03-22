<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimensao extends Model
{
    use HasFactory;

    protected $table = 'dimensoes';

    protected $fillable = [
        'nome',
        'eixo_estrategico_id'
    ];

    public function eixo_estrategico()
    {
        return $this->belongsTo(EixoEstrategico::class);
    } 
}
