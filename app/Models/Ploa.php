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

    public static function valores($ploa) {
        $dados['valor_distribuido'] = 0;
        $dados['valor_a_distribuir'] = 0;
        $dados['valor_planejado'] = 0;
        $dados['valor_a_planejar'] = 0;
        $dados['valor_recebido'] = 0;
        $dados['valor_a_receber'] = 0;

        if(count($ploa->ploas_gestoras) > 0) {
            $dados['valor_distribuido'] += $ploa->ploas_gestoras()->sum('valor');
            foreach($ploa->ploas_gestoras as $ploa_gestora) {
                if(count($ploa_gestora->ploas_administrativas) > 0) {
                    foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa) {
                        $dados['valor_planejado'] += $ploa_administrativa->despesas()->sum('valor_total');
                    }
                }
            }
        } 

        $dados['valor_recebido'] = $ploa->loas()->sum('valor');
        $dados['valor_a_distribuir'] = $ploa->valor - $dados['valor_distribuido'];
        $dados['valor_a_planejar'] = $dados['valor_distribuido'] - $dados['valor_planejado'];
        $dados['valor_a_receber'] = $ploa->valor - $dados['valor_recebido'];

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

    public function loas()
    {
        return $this->hasMany(Loa::class);
    }
}
