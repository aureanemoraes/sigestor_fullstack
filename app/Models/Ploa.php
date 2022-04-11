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


    // public static function valorDistribuido($ploa) {
    //     if(count($ploa->ploas_gestoras) > 0) {
    //         $valor_distribuido = $ploa->ploas_gestoras->sum('valor');
    //         return $valor_distribuido;
    //     } else {
    //         return 0;
    //     }
    // }

    // public static function valorDistribuir($valor_ploa, $valor_distribuido) {
    //     $valor_a_distribuir = $valor_ploa - $valor_distribuido;
    //     return $valor_a_distribuir;
    // }

    public static function valores($ploa) {
        $dados['valor_distribuido'] = 0;
        $dados['valor_a_distribuir'] = 0;
        $dados['valor_planejado'] = 0;
        $dados['valor_a_planejar'] = 0;

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

        return $dados;
    }

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

    public function ploas_gestoras()
    {
        return $this->hasMany(PloaGestora::class);
    }
}
