<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remanejamento extends Model
{
    use HasFactory;

    protected $table = 'remanejamentos';

    protected $fillable = [
        'qtd',
        'valor',
        'numero_oficio',
        'data',
        'despesa_remetente_id',
        'despesa_destinatario_id'
    ];

    public function despesa_remetente()
    {
        return $this->belongsTo(Despesa::class, 'despesa_remetente_id', 'id');
    }

    public function despesa_destinatario()
    {
        return $this->belongsTo(Despesa::class, 'despesa_destinatario_id', 'id');
    }
}
