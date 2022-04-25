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

    public static function valores($programa, $tipo, $id=null, $exercicio_id=null) {
        $dados['valor_total'] = 0;
        $dados['valor_distribuido'] = 0;
        $dados['valor_a_distribuir'] = 0;
        $dados['valor_planejado'] = 0;
        $dados['valor_a_planejar'] = 0;
        $dados['valor_recebido'] = 0;
        $dados['valor_a_receber'] = 0;
        $valor_total_programa = 0;

        switch($tipo) {
            case 'ploa':
                if(count($programa->ploas) > 0) {
                    $dados['valor_total'] = $programa->ploas()->sum('valor');
                    foreach($programa->ploas as $ploa) {
                        if(count($ploa->ploas_gestoras) > 0) {
                            $dados['valor_recebido'] += $ploa->loas()->sum('valor');
                            $dados['valor_distribuido'] += $ploa->ploas_gestoras()->sum('valor');
                            foreach($ploa->ploas_gestoras as $ploa_gestora) {
                                if(count($ploa_gestora->ploas_administrativas) > 0) {
                                    foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa) {
                                        $dados['valor_planejado'] += $ploa_administrativa->despesas()->sum('valor_total');
                                    }
                                }
                            }
                        } 
                        $valor_total_programa += $ploa->valor;
                    }

                    $dados['valor_a_distribuir'] = $valor_total_programa - $dados['valor_distribuido'];
                    $dados['valor_a_planejar'] = $dados['valor_distribuido'] - $dados['valor_planejado'];
                    $dados['valor_a_receber'] = $valor_total_programa - $dados['valor_recebido'];
                }
            break;
            case 'ploa_gestora':
                $ploas_gestoras = PloaGestora::whereHas(
                    'ploa', function ($query) use ($programa, $exercicio_id) {
                        $query->where('programa_id', $programa->id);
                        $query->where('exercicio_id', $exercicio_id);
                    }
                )->where('unidade_gestora_id', $id)->get();

                $dados['valor_total'] = $ploas_gestoras->sum('valor');

                foreach($ploas_gestoras as $ploa_gestora) {
                    if(count($ploa_gestora->ploas_administrativas) > 0) {
                        $dados['valor_distribuido'] += $ploa_gestora->ploas_administrativas()->sum('valor');

                        foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa) {
                            $dados['valor_planejado'] += $ploa_administrativa->despesas()->sum('valor_total');
                        }
                    }
                }

                $dados['valor_a_distribuir'] = $ploa_gestora->valor - $dados['valor_distribuido'];
                $dados['valor_a_planejar'] = $dados['valor_distribuido'] - $dados['valor_planejado'];
            break;
            case 'ploa_administrativa':
                $ploas_administrativas = PloaAdministrativa::whereHas(
                    'ploa_gestora', function ($query) use ($programa, $exercicio_id) {
                        $query->whereHas(
                            'ploa', function ($query) use ($programa, $exercicio_id) {
                                $query->where('programa_id', $programa->id);
                                $query->where('exercicio_id', $exercicio_id);
                            }
                        );
                    }
                )->where('unidade_administrativa_id', $id)->get();

                $dados['valor_total'] = $ploas_administrativas->sum('valor');

                foreach($ploas_administrativas as $ploa_administrativa) {
                    $dados['valor_planejado'] += $ploa_administrativa->despesas()->sum('valor_total');
                }

                $dados['valor_a_planejar'] = $dados['valor_total'] - $dados['valor_planejado'];
            break;
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