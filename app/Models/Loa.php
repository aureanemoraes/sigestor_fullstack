<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loa extends Model
{
    use HasFactory;

    protected $table = 'loas';

    protected $fillable = [
        'descricao',
        'tipo',
        'valor',
        'ploa_id',
        'data_recebimento'
    ];

    public function ploa()
    {
        return $this->belongsTo(Ploa::class);
    }
}
