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
    
    public function setCodigoCertidaoAttribute($value)
    {
        $query = CertidaoCredito::orderBy('created_at', 'desc')->first();

        $last_id = isset($query) ? $query->id + 1 : 1;

        $this->attributes['codigo_certidao'] = str_pad($last_id, '0', STR_PAD_LEFT); 
    }

    public function credito_planejado()
    {
        return $this->belongsTo(CreditoPlanejado::class);
    } 
}
