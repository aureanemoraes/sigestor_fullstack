<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class NaturezaDespesa extends Model
{
    use HasFactory;
    

    protected $table = 'naturezas_despesas';

    protected $fillable = [
        'nome',
        'codigo',
        'tipo',
        'fav',
        'fields'
    ];

    protected $casts = [
        'fields' => 'array',
        'valores' => 'array'
    ];

    protected $appends = ['nome_completo'];

    public function getValoresAttribute()
    {
        $valores['total_custo_fixo'] = $this->despesas()->where('tipo', 'despesa_fixa')->sum('valor_total');
        $valores['total_custo_variavel'] = $this->despesas()->where('tipo', 'despesa_variavel')->sum('valor_total');
        $valores['total'] = $valores['total_custo_fixo'] + $valores['total_custo_variavel']; 

        return $valores;
    }

    public static function valores($natureza_despesa, $acao_id, $exercicio_id, $unidade_administrativa_id) {
        $dados['valor_total'] = 0;
        $dados['total_limite_recebido'] = 0;
        $dados['a_receber'] = 0;
        
        $despesas = $natureza_despesa->despesas()->whereHas('ploa_administrativa', function($query) use($unidade_administrativa_id, $exercicio_id, $acao_id) {
            $query->where('unidade_administrativa_id', $unidade_administrativa_id);
            $query->whereHas('ploa_gestora', function($query) use($unidade_administrativa_id, $exercicio_id, $acao_id) {
                $query->whereHas('ploa', function($query) use($unidade_administrativa_id, $exercicio_id, $acao_id) {
                    $query->where('acao_tipo_id', $acao_id);
                    $query->where('exercicio_id', $exercicio_id);
                });
            });
        })->get();

        foreach($despesas as $despesa) {
            $dados['valor_total'] += $despesa->valor_total;
            $dados['total_limite_recebido'] += $despesa->valor_recebido;
            $dados['a_receber'] += $despesa->valor_disponivel;
        }

        return $dados;
    }

    public function getNomeCompletoAttribute()
    {
        return $this->attributes['codigo'] . ' - ' . $this->attributes['nome'];
    }

    public function subnaturezas_despesas()
    {
        return $this->hasMany(SubnaturezaDespesa::class);
    }

    public function despesas_modelos()
    {
        return $this->hasMany(DespesaModelo::class);
    }

    public function despesas()
    {
        return $this->hasMany(Despesa::class);
    }
}
