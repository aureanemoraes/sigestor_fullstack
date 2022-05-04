<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaGestora extends Model
{
    use HasFactory;

    protected $table = 'loas';

    protected $fillable = [
        'descricao',
        'tipo',
        'valor',
        'ploa_gestora_id',
        'data_recebimento'
    ];

    public function ploa()
    {
        return $this->belongsTo(Ploa::class);
    }
}
