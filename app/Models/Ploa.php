<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ploa extends Model
{
    use HasFactory;

    protected $table = 'ploas';

    protected $fillable = [
        'exercicio_id',
        'programa_id',
        'fonte_tipo_id',
        'acao_tipo_id',
        'instituicao_id',
        'tipo_acao',
        'valor'
    ];

    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class);
    }

    public function fonte_tipo()
    {
        return $this->belongsTo(FonteTipo::class);
    }

    public function acao_tipo()
    {
        return $this->belongsTo(AcaoTipo::class);
    }

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    }
}
