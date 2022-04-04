<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class NaturezaDespesa extends Model
{
    use HasFactory;
    

    protected $table = 'naturezas_despesas';

    protected $fillable = [
        'nome',
        'codigo',
        'tipo',
        'fav',
        'fields'
    ];

    protected $with = [
        'subnaturezas_despesas'
    ];

    protected $casts = [
        'fields' => 'array'
    ];

    public function subnaturezas_despesas()
    {
        return $this->hasMany(SubnaturezaDespesa::class);
    }
    
}
