<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;

    protected $table = 'programas';

    protected $fillable = [
        'codigo',
        'nome',
        'fav'
    ];

    public static function valores($programa) {
        $dados['valor_total'] = 0;
        $dados['valor_distribuido'] = 0;
        $dados['valor_a_distribuir'] = 0;
        $dados['valor_planejado'] = 0;
        $dados['valor_a_planejar'] = 0;

        if(count($programa->ploas) > 0) {
            $dados['valor_total'] = $programa->ploas()->sum('valor');
            foreach($programa->ploas as $ploa) {
                if(count($ploa->ploas_gestoras) > 0) {
                    $dados['valor_distribuido'] = $ploa->ploas_gestoras->sum('valor');
                    foreach($ploa->ploas_gestoras as $ploa_gestora) {
                        if(count($ploa_gestora->ploas_administrativas) > 0) {
                            $dados['valor_planejado'] += $ploa_gestora->ploas_administrativas->sum('valor');
                        }
                    }
                } 
        
                $dados['valor_a_distribuir'] = $ploa->valor - $dados['valor_distribuido'];
                $dados['valor_a_planejar'] = $dados['valor_distribuido'] - $dados['valor_planejado'];
            }
        }

        

        return $dados;
    }

    public function fontes()
    {
        return $this->belongsToMany(Fonte::class, 'fontes_programas', 'programa_id', 'fonte_id')->withPivot(
            'exercicio_id',
        );
    }

    public function ploas()
    {
        return $this->hasMany(Ploa::class);
    }
}