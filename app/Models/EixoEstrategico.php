<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EixoEstrategico extends Model
{
    use HasFactory;

    protected $table = 'eixos_estrategicos';

    protected $fillable = [
        'nome',
        'plano_estrategico_id',
    ];

    protected $appends = ['porcentagem_atual'];

    public function getPorcentagemAtualAttribute()
    {
        $qtd_objetivos      = 0;
        $total_objetivos    = 0;

        if(count($this->dimensoes) > 0) {
            foreach($this->dimensoes as $dimensao) {
                $total_objetivos    += $dimensao->objetivos->sum('porcentagem_atual');
                foreach($dimensao->objetivos as $objetivo) {
                    if(count($objetivo->metas) > 0)
                        $qtd_objetivos++;
                }
            }
            $porcentagem_atual = ($total_objetivos * 100)/(100 * $qtd_objetivos);
            return $porcentagem_atual;
        } else
            return 0;
    }

    public function plano_estrategico()
    {
        return $this->belongsTo(PlanoEstrategico::class);
    }

    public function dimensoes()
    {
        return $this->hasMany(Dimensao::class);
    }
}
