<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AcaoTipo extends Model
{
    use HasFactory;
    

    protected $table = 'acoes_tipos';

    protected $fillable = [
        'codigo',
        'nome',
        'nome_simplificado',
        'fav',
        'custeio',
        'investimento'
    ];

    protected $appends = ['nome_completo'];

    public function getNomeCompletoAttribute()
    {
        return $this->attributes['codigo'] . ' - ' . $this->attributes['nome'];
    }

    public function ploas()
    {
        return $this->hasMany(Ploa::class);
    }
}
