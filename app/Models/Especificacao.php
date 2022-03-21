<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Especificacao extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';

    protected $table = 'especificacoes';

    protected $fillable = [
        'id',
        'nome',
        'fav'
    ];

    // Adicionar accessor para exibir o 0 na frente de números com somente uma casa decimal
    // public function getIdAttribute($value)
    // {
    //     $id = str_pad($value, 2, '0', STR_PAD_LEFT); 
   
    //     return $id;
    // }
}
