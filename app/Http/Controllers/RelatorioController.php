<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcaoTipo;
use App\Models\UnidadeGestora;
use App\Models\Instituicao;
use App\Models\Exercicio;
use App\Models\UnidadeAdministrativa;
use App\Models\NaturezaDespesa;

class RelatorioController extends Controller
{
    public function index() {
        return view('relatorio.index');
    }

    public function relatorio_matriz($instituicao_id, $exercicio_id) {
        $acoes = AcaoTipo::where('fav', 1)->get();
        $instituicao = Instituicao::find($instituicao_id);
        $exercicio = Exercicio::find($exercicio_id);
        $valor_ploa = 0;

        $dados = [];

        $dados_acoes_gestoras = [];

        $unidades_gestoras = UnidadeGestora::where('instituicao_id', $instituicao_id)->get();

        $i = 0;
        foreach($unidades_gestoras as $unidade_gestora) {
            $valor_total = 0;
            $dados['unidades_gestoras'][$i]['uasg'] = $unidade_gestora->uasg;
            $dados['unidades_gestoras'][$i]['nome'] = $unidade_gestora->nome;

            $j = 0;
            foreach($acoes as $acao) {
                $valor_custeio  = 0;
                $valor_investimento = 0;
                $dados['unidades_gestoras'][$i]['acoes'][$j]['nome_simplificado'] = $acao->nome_simplificado;
                $dados['unidades_gestoras'][$i]['acoes'][$j]['codigo'] = $acao->codigo;

                foreach($unidade_gestora->ploas_gestoras as $ploa_gestora) {
                    if($ploa_gestora->ploa->acao_tipo_id == $acao->id && $ploa_gestora->ploa->tipo_acao == 'custeio') {
                        $valor_custeio += $ploa_gestora->valor; 
                    }

                    if($ploa_gestora->ploa->acao_tipo_id == $acao->id && $ploa_gestora->ploa->tipo_acao == 'investimento') {
                        $valor_investimento += $ploa_gestora->valor; 
                    }
                }

                if($acao->custeio) {
                    $dados['unidades_gestoras'][$i]['acoes'][$j]['custeio'] = $valor_custeio;
                    if(isset($dados_acoes_gestoras[$acao->codigo]['valor_total_custeio']))
                        $dados_acoes_gestoras[$acao->codigo]['valor_total_custeio'] += $valor_custeio;
                    else
                        $dados_acoes_gestoras[$acao->codigo]['valor_total_custeio'] = 0;
                }

                if($acao->investimento) {
                    $dados['unidades_gestoras'][$i]['acoes'][$j]['investimento'] = $valor_investimento;
                    if(isset($dados_acoes_gestoras[$acao->codigo]['valor_total_investimento']))
                        $dados_acoes_gestoras[$acao->codigo]['valor_total_investimento'] += $valor_investimento;
                    else
                        $dados_acoes_gestoras[$acao->codigo]['valor_total_investimento'] = 0;
                }

                $valor_total    += $valor_custeio + $valor_investimento;
                $j++;
            }

            $dados['unidades_gestoras'][$i]['valor_total']      = $valor_total;
            $valor_ploa                                         += $valor_total;

            $k = 0;
            foreach($unidade_gestora->unidades_administrativas as $unidade_administrativa) {
                $valor_total = 0;
                $dados['unidades_gestoras'][$i]['unidades_administrativas'][$k]['uasg'] = $unidade_administrativa->uasg;
                $dados['unidades_gestoras'][$i]['unidades_administrativas'][$k]['nome'] = $unidade_administrativa->nome;

                $j = 0;
                foreach($acoes as $acao) {
                    $valor_custeio  = 0;
                    $valor_investimento = 0;
                    $dados['unidades_gestoras'][$i]['unidades_administrativas'][$k]['acoes'][$j]['nome_simplificado'] = $acao->nome_simplificado;
                    $dados['unidades_gestoras'][$i]['unidades_administrativas'][$k]['acoes'][$j]['codigo'] = $acao->codigo;
    
                    foreach($unidade_administrativa->ploas_administrativas as $ploa_administrativa) {
                        if($ploa_administrativa->ploa_gestora->ploa->acao_tipo_id == $acao->id && $ploa_administrativa->ploa_gestora->ploa->tipo_acao == 'custeio') {
                            $valor_custeio += $ploa_administrativa->valor; 
                        }
    
                        if($ploa_administrativa->ploa_gestora->ploa->acao_tipo_id == $acao->id && $ploa_administrativa->ploa_gestora->ploa->tipo_acao == 'investimento') {
                            $valor_investimento += $ploa_administrativa->valor; 
                        }
                    }
                    
    
                    if($acao->custeio) {
                        $dados['unidades_gestoras'][$i]['unidades_administrativas'][$k]['acoes'][$j]['custeio'] = $valor_custeio;
                    }
    
                    if($acao->investimento) {
                        $dados['unidades_gestoras'][$i]['unidades_administrativas'][$k]['acoes'][$j]['investimento'] = $valor_investimento;
                    }
    
                    $valor_total    += $valor_custeio + $valor_investimento;
                    $j++;
                }
                $dados['unidades_gestoras'][$i]['unidades_administrativas'][$k]['valor_total']      = $valor_total;
                $k++;
            }
            $i++;
        }

        $dados['valor_ploa'] = $valor_ploa;


        return view('relatorio.matriz')->with([
            'acoes' => $acoes,
            'unidades_gestoras' => $unidades_gestoras,
            'instituicao' => $instituicao,
            'exercicio' => $exercicio,
            'dados' => $dados,
            'dados_acoes_gestoras' => $dados_acoes_gestoras
        ]);
    }

    public function relatorio_planejamento($unidade_administrativa_id, $exercicio_id)
    {
        $exercicio = Exercicio::find($exercicio_id);
        $unidade_administrativa = UnidadeAdministrativa::find($unidade_administrativa_id);

        $acoes = AcaoTipo::where('fav', 1)->get();

        $naturezas_despesas = NaturezaDespesa::where('fav', 1)->get();

        foreach($acoes as $acao) {
            $dados['acoes'][$acao->codigo]['nome_completo'] = $acao->nome_completo;
            $dados['acoes'][$acao->codigo]['naturezas_despesas'] = [];
        }

        foreach($naturezas_despesas as $natureza_despesa) {
            $despesas = $natureza_despesa->despesas()->whereHas(
                'ploa_administrativa', function ($query) use($unidade_administrativa_id, $exercicio_id) {
                    $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                    $query->whereHas('ploa_gestora', function ($query_2) use($unidade_administrativa_id, $exercicio_id){
                        $query_2->whereHas('ploa', function ($query_3) use($unidade_administrativa_id, $exercicio_id){
                            $query_3->where('exercicio_id', $exercicio_id);
                        });
                    });
                }
            )->get();

            if(count($despesas) > 0) {
                $i = 0;
                foreach($despesas as $despesa) {
                    $acao_codigo = $despesa->ploa_administrativa->ploa_gestora->ploa->acao_tipo->codigo;
                    $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['nome'] = $natureza_despesa->codigo . ' - '. $natureza_despesa->nome;

                    $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['fields'] = $natureza_despesa->fields;

                    $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['despesas'][$i]['nome'] = $despesa->descricao;

                    $j = 0;
                    
                    if(count($natureza_despesa->fields) > 0) {
                        foreach($natureza_despesa->fields as $field) {
                            $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['despesas'][$i]['fields'][$j]['label'] = $field['label'];

                            $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['despesas'][$i]['fields'][$j]['valor'] = $despesa->fields[$field['slug']]['valor'];

                            $j++;
                        }
                    }

                    $j++;
                    $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['despesas'][$i]['fields'][$j]['label'] = 'Valor';
                    $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['despesas'][$i]['fields'][$j]['valor'] = $despesa->valor;
                    $j++;
                    $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['despesas'][$i]['fields'][$j]['label'] = 'Valor total';
                    $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['despesas'][$i]['fields'][$j]['valor'] = $despesa->valor_total;

                    $dados['acoes'][$acao_codigo]['naturezas_despesas'][$natureza_despesa->codigo]['despesas'][$i]['tipo'] = $despesa->tipo;

                    $i++;
                }
            }

        }

        return view('relatorio.planejamento')->with([
            'exercicio' => $exercicio,
            'unidade_administrativa' => $unidade_administrativa,
            'acoes' => $acoes,
            'dados' => $dados
        ]);
    }
}
