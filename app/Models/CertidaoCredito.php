<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertidaoCredito extends Model
{
    use HasFactory;

    protected $table = 'certidoes_creditos';

    protected $fillable = [
        'id',
        'codigo_certidao',
        'credito_planejado_id',
    ];

    protected $appends = [
        'unidade',
        'fonte',
        'acao',
        'natureza_despesa'
    ];
    
    public function setCodigoCertidaoAttribute($value)
    {
        $query = CertidaoCredito::orderBy('created_at', 'desc')->first();

        $last_id = isset($query) ? $query->id + 1 : 1;

        $exercicio = $this->credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->exercicio->nome;

        $this->attributes['codigo_certidao'] = str_pad($last_id, 4, '0', STR_PAD_LEFT) . '/' . $exercicio; 
    }

    public function getUnidadeAttribute()
    {
        return $this->credito_planejado->despesa->ploa_administrativa->unidade_administrativa->nome_completo;
    }

    public function getFonteAttribute()
    {
        return $this->credito_planejado->despesa->fonte;
    }

    public function getAcaoAttribute()
    {
        return $this->credito_planejado->despesa->acao;
    }

    public function getNaturezaDespesaAttribute()
    {
        return $this->credito_planejado->despesa->natureza_despesa->nome_completo;
    }

    public function credito_planejado()
    {
        return $this->belongsTo(CreditoPlanejado::class);
    } 

    public function empenho()
    {
        return $this->hasOne(Empenho::class);
    } 
}
