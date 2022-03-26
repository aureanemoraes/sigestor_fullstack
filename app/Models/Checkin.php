<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $table = 'checkins';

    use HasFactory;

    protected $fillable = [
        'valor',
        'descricao'
    ];

    protected $appends = ['valor_formatado', 'data_formatada'];

    public function getValorFormatadoAttribute($value)
    {
        return formatMetaValue($this->valor, $this->meta->tipo_dado);
    }

    public function getDataFormatadaAttribute($value)
    {
        return formatDate($this->created_at);
    }


    public function meta()
    {
        return $this->belongsTo(Meta::class);
    } 
}
