<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AcaoTipo extends Model
{
    use HasFactory;
    

    protected $table = 'acoes_tipos';

    protected $fillable = [
        'codigo',
        'nome',
        'nome_simplificado',
        'fav',
        'custeio',
        'investimento'
    ];

    protected $appends = ['nome_completo', 'tipos'];

    protected $casts = ['tipos' => 'array'];

    public function getNomeCompletoAttribute()
    {
        return $this->attributes['codigo'] . ' - ' . $this->attributes['nome'];
    }

    public function getTiposAttribute()
    {
        $tipos = [];
        if($this->custeio)
            $tipos[] = 'custeio';

        if($this->investimento)
            $tipos[] = 'investimento';

        return $tipos;
    }

    public function ploas()
    {
        return $this->hasMany(Ploa::class);
    }

    public function ploas_administrativas()
    {
        return $this->hasMany(PloaAdministrativa::class);
    }
}
