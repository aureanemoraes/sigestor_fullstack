<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PloaAdministrativa extends Model
{
    use HasFactory;

    protected $table = 'ploas_administrativas';

    protected $fillable = [
        'ploa_gestora_id',
        'unidade_administrativa_id',
        'valor'
    ];

    public static function valores($ploa_administrativa) {
        $dados['valor_distribuido'] = 0;
        $dados['valor_a_distribuir'] = 0;
        $dados['valor_planejado'] = 0;
        $dados['valor_a_planejar'] = 0;

        if(count($ploa_administrativa->despesas) > 0) {
            $dados['valor_planejado'] += $ploa_administrativa->despesas()->sum('valor_total');
        } 

        $dados['valor_a_planejar'] = $ploa_administrativa->valor - $dados['valor_planejado'];

        return $dados;
    }

    public function ploa_gestora()
    {
        return $this->belongsTo(PloaGestora::class);
    }

    public function despesas()
    {
        return $this->hasMany(Despesa::class);
    }

    public function unidade_administrativa()
    {
        return $this->belongsTo(UnidadeAdministrativa::class);
    }
}
