<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PloaGestora extends Model
{
    use HasFactory;

    protected $table = 'ploas_gestoras';

    protected $fillable = [
        'ploa_id',
        'unidade_gestora_id',
        'valor'
    ];

    public static function valores($ploa_gestora) {
        $dados['valor_distribuido'] = 0;
        $dados['valor_a_distribuir'] = 0;
        $dados['valor_planejado'] = 0;
        $dados['valor_a_planejar'] = 0;

        if(count($ploa_gestora->ploas_administrativas) > 0) {
            $dados['valor_distribuido'] = $ploa_gestora->ploas_administrativas()->sum('valor');
            foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa) {
                foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa) {
                    $dados['valor_planejado'] += $ploa_administrativa->despesas()->sum('valor_total');
                }
            }
        } 

        $dados['valor_a_distribuir'] = $ploa_gestora->valor - $dados['valor_distribuido'];
        $dados['valor_a_planejar'] = $dados['valor_distribuido'] - $dados['valor_planejado'];

        return $dados;
    }

    public function ploa()
    {
        return $this->belongsTo(Ploa::class);
    }

    public function ploas_administrativas()
    {
        return $this->hasMany(PloaAdministrativa::class);
    }

}
