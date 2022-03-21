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
        'fav',
        'custeio',
        'investimento'
    ];
}
