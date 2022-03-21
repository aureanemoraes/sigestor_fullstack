<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    use HasFactory;

    protected $table = 'movimentos';

    protected $fillable = [
        'descricao',
        'valor',
        'exercicio_id',
        'tipo'
    ];

    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    } 
}
