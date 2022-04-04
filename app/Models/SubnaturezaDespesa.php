<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubnaturezaDespesa extends Model
{
    use HasFactory;
    

    protected $table = 'subnaturezas_despesas';

    protected $fillable = [
        'nome',
        'codigo',
        'natureza_despesa_id'
    ];

    protected $casts = [
        'fields' => 'array'
    ];

    public function natureza_despesa() 
    {
        return $this->belongsTo(NaturezaDespesa::class);
    }
}
