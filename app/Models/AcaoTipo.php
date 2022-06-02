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

    protected $appends = ['nome_completo', 'tipos', 'valores'];

    protected $casts = ['tipos' => 'array', 'valores' => 'array'];

    public function getNomeCompletoAttribute()
    {
        return $this->attributes['codigo'] . ' - ' . $this->attributes['nome'];
    }

    // public function getTotalMatrizAttribute()
    // {
    //     return $this->ploas()->sum('valor');
    // }

    public function getValoresAttribute()
    {
        $valores                                        = [];
        $valores['custeio']['total_matriz']             = 0;
        $valores['investimento']['total_matriz']        = 0;
        $valores['custeio']['total_planejado']          = 0;
        $valores['investimento']['total_planejado']     = 0;
        // dd($this->ploas->toArray());

        if(count($this->ploas) > 0) {
            foreach($this->ploas as $ploa) {
                if($ploa->tipo_acao == 'custeio') {
                    $valores['custeio']['total_matriz'] += $ploa->valor;
                } else {
                    $valores['investimento']['total_matriz'] += $ploa->valor;
                }
    
                if(count($ploa->ploas_gestoras) > 0) {
                    foreach($ploa->ploas_gestoras as $ploa_gestora) {
                        if(count($ploa_gestora->ploas_administrativas) > 0) {
                            foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa) {
                                // dd($ploa_gestora->ploas_administrativas->toArray());
                                if($ploa->tipo_acao == 'custeio') {
                                    $valores['custeio']['total_planejado'] += $ploa_administrativa->despesas()->sum('valor_total');
                                }  
                                if($ploa->tipo_acao == 'investimento') {
                                    $valores['investimento']['total_planejado'] += $ploa_administrativa->despesas()->sum('valor_total');
                                }
                            }
                        }
                    }
                } 
            }
        }

        $valores['custeio']['saldo_a_planejar'] = $valores['custeio']['total_matriz'] - $valores['custeio']['total_planejado'];
        $valores['investimento']['saldo_a_planejar'] = $valores['investimento']['total_matriz'] - $valores['investimento']['total_planejado'];

        return $valores;
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

    public function metas_orcamentarias()
    {
        return $this->hasMany(MetaOrcamentaria::class);
    }
}
