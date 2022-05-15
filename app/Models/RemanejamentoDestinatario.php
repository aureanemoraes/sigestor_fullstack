<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemanejamentoDestinatario extends Model
{
    use HasFactory;

    protected $table = 'remanejamentos_destinatarios';

    protected $fillable = [
        'valor',
        'remanejamento_id',
        'despesa_destinatario_id'
    ];

    public function remanejamento()
    {
        return $this->belongsTo(Remanejamento::class, 'remanejamento_id', 'id');
    }

    public function despesa_destinatario()
    {
        return $this->belongsTo(Despesa::class, 'despesa_destinatario_id', 'id');
    }
}
