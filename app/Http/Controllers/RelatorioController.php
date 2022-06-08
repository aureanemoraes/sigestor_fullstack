<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcaoTipo;
use App\Models\UnidadeGestora;
use App\Models\Instituicao;
use App\Models\Exercicio;
use App\Models\Despesa;
use App\Models\UnidadeAdministrativa;
use App\Models\NaturezaDespesa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class RelatorioController extends Controller
{
    public function index() {
        return view('relatorio.index');
    }

    public function relatorioSimplificado(Request $request) 
    {
        DB::connection()->enableQueryLog();
        $exercicio                  = isset($request->exercicio_id) ? Exercicio::find($request->exercicio_id) : Exercicio::first();
        $exercicio_id               = $exercicio->id;
        $instituicao_id             = 1;
        $unidade_gestora_id         = isset($request->unidade_gestora_id) ? $request->unidade_gestora_id : null;
        $unidade_administrativa_id  = isset($request->unidade_administrativa_id) ? $request->unidade_administrativa_id : null;

        if(isset($instituicao_id))
            $tipo_relatorio             = 'institucional';
        if(isset($unidade_gestora_id))
            $tipo_relatorio             = 'gestor';
        if(isset($unidade_administrativa_id))
            $tipo_relatorio             = 'administrativo';

        $valores_totais['matriz']               = 0;
        $valores_totais['planejado']            = 0;
        $valores_totais['saldo_a_planejar']     = 0;
        $valores_totais['despesas_fixas']       = 0;
        $valores_totais['despesas_variaveis']   = 0;

        $dados                                  = [];


        switch($tipo_relatorio) {
            case 'institucional':
                $entidade = Instituicao::find($instituicao_id);
                break;
            case 'gestor':
                $entidade = UnidadeGestora::find($unidade_gestora_id);
                break;
            case 'administrativo':
                $entidade = UnidadeAdministrativa::find($unidade_administrativa_id);
                break;
        }

        $acoes = AcaoTipo::whereHas('ploas', function ($query) use($exercicio_id, $instituicao_id, $unidade_gestora_id, $unidade_administrativa_id) {
            $query->where('exercicio_id', $exercicio_id);
            $query->where('instituicao_id', $instituicao_id);
            $query->whereHas('ploas_gestoras', function ($query) use($exercicio_id, $instituicao_id, $unidade_gestora_id, $unidade_administrativa_id) {
                if(isset($unidade_gestora_id)) {
                    $query->where('unidade_gestora_id', $unidade_gestora_id);
                }
                $query->whereHas('ploas_administrativas', function ($query) use($exercicio_id, $instituicao_id, $unidade_gestora_id, $unidade_administrativa_id) {
                    if(isset($unidade_administrativa_id)) {
                        $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                    }
                    $query->whereHas('despesas');
                });
            });
        })
        ->get();

        $teste = [];
        
        foreach($acoes as $acao) {
            $acao->setAppends(['valores']);
            $valores_totais['matriz']               += $acao->valores['custeio']['total_matriz'] + $acao->valores['investimento']['total_matriz'];
            $valores_totais['planejado']            += $acao->valores['custeio']['total_planejado'] + $acao->valores['investimento']['total_planejado'];
            $valores_totais['saldo_a_planejar']     += $acao->valores['custeio']['saldo_a_planejar'] + $acao->valores['investimento']['saldo_a_planejar'];

            $acao_id = $acao->id;

            $acao['total_custo_fixo']       = 0;
            $acao['total_custo_variavel']   = 0;
            $acao['total']                  = 0;

            if(count($acao->tipos) > 0) {
                foreach($acao->tipos as $tipo_acao) {
                    $callbackDespesa = function ($query) use($exercicio_id, $instituicao_id, $acao_id, $tipo_acao, $unidade_gestora_id, $unidade_administrativa_id) {
                        $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $tipo_acao, $unidade_gestora_id, $unidade_administrativa_id) {
                            if(isset($unidade_administrativa_id)) {
                                $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                            }
                            $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $tipo_acao, $unidade_gestora_id, $unidade_administrativa_id) {
                                if(isset($unidade_gestora_id)) {
                                    $query->where('unidade_gestora_id', $unidade_gestora_id);
                                }
                                $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $tipo_acao, $unidade_gestora_id, $unidade_administrativa_id) {
                                    $query->where('exercicio_id', $exercicio_id);
                                    $query->where('instituicao_id', $instituicao_id);
                                    $query->where('acao_tipo_id', $acao_id);
                                    $query->where('tipo_acao', $tipo_acao);
                                });
                            });
                        });
                    };
                    
                    $callbackNaturezaDespesa = function ($query) use($exercicio_id, $instituicao_id, $acao_id, $tipo_acao, $unidade_gestora_id, $unidade_administrativa_id){
                        $query->whereHas('despesas', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $tipo_acao, $unidade_gestora_id, $unidade_administrativa_id) {
                            $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $tipo_acao, $unidade_gestora_id, $unidade_administrativa_id) {
                                if(isset($unidade_administrativa_id)) {
                                    $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                                }
                                $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $tipo_acao, $unidade_gestora_id, $unidade_administrativa_id) {
                                    if(isset($unidade_gestora_id)) {
                                        $query->where('unidade_gestora_id', $unidade_gestora_id);
                                    }
                                    $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $tipo_acao, $unidade_gestora_id, $unidade_administrativa_id) {
                                        $query->where('exercicio_id', $exercicio_id);
                                        $query->where('instituicao_id', $instituicao_id);
                                        $query->where('acao_tipo_id', $acao_id);
                                        $query->where('tipo_acao', $tipo_acao);
                                    });
                                });
                            });
                        });
                    };

                    $acao[$tipo_acao] = [
                        'naturezas_despesas' => NaturezaDespesa::with('despesas')->whereHas('despesas', $callbackDespesa)
                        ->orWhereHas('subnaturezas_despesas', $callbackNaturezaDespesa)
                        ->with(['despesas' => $callbackDespesa])
                        ->get(),
                        'total_custo_fixo' => 0,
                        'total_custo_variavel' => 0,
                        'total' => 0,
                    ];
                }
            }

            $coringa_acao = $acao;

            if(count($acao->tipos) > 0) {
                foreach($acao->tipos as $tipo_acao) {
                    if(isset($acao[$tipo_acao]) && count($acao[$tipo_acao]['naturezas_despesas']) > 0) {
                        $coringa_tipo_acao                                    = $acao[$tipo_acao];

                        foreach($acao[$tipo_acao]['naturezas_despesas'] as $natureza_despesa) {
                            $natureza_despesa['custo_fixo']         = 0;
                            $natureza_despesa['custo_variavel']     = 0;
                            $natureza_despesa['total']              = 0;

                            foreach($natureza_despesa->despesas as $despesa) {
                                if($despesa->tipo == 'despesa_fixa') {
                                    $natureza_despesa['custo_fixo']             += $despesa->valor_total;
                                    $valores_totais['despesas_fixas']           += $despesa->valor_total;
                                }
                                else {
                                    $natureza_despesa['custo_variavel']         += $despesa->valor_total;
                                    $valores_totais['despesas_variaveis']       += $despesa->valor_total;
                                }
                            }

                            $natureza_despesa['total']              += $natureza_despesa['custo_fixo'] + $natureza_despesa['custo_variavel'] ;

                            if(count($natureza_despesa->subnaturezas_despesas) > 0) {
                                foreach($natureza_despesa->subnaturezas_despesas as $subnatureza_despesa) {
                                    foreach($subnatureza_despesa->despesas as $despesa) {
                                        if($despesa->tipo == 'despesa_fixa') {
                                            $subnatureza_despesa['custo_fixo']         += $despesa->valor_total;
                                            $valores_totais['despesas_fixas']       += $despesa->valor_total;
                                        }
                                        else {
                                            $subnatureza_despesa['custo_variavel']         += $despesa->valor_total;
                                            $valores_totais['despesas_variaveis']       += $despesa->valor_total;
                                        }
                                    }
                                    $subnatureza_despesa['total'] += $natureza_despesa['custo_fixo'] + $natureza_despesa['custo_variavel'] ;

                                    $coringa_tipo_acao['total_custo_fixo']            += $subnatureza_despesa['custo_fixo'];
                                    $coringa_tipo_acao['total_custo_variavel']        += $subnatureza_despesa['custo_variavel'];
                                    $coringa_tipo_acao['total']                       += $subnatureza_despesa['total'];
                                }
                            }

                            $coringa_tipo_acao['total_custo_fixo']            += $natureza_despesa['custo_fixo'];
                            $coringa_tipo_acao['total_custo_variavel']        += $natureza_despesa['custo_variavel'];
                            $coringa_tipo_acao['total']                       += $natureza_despesa['total'];
                        }  

                        $coringa_acao['total_custo_fixo']            += $coringa_tipo_acao['total_custo_fixo'];
                        $coringa_acao['total_custo_variavel']        += $coringa_tipo_acao['total_custo_variavel'];
                        $coringa_acao['total']                       += $coringa_tipo_acao['total'];

                        $acao[$tipo_acao]                           = $coringa_tipo_acao;
                    }
                }
            }

            $acao = $coringa_acao;
        }

        return view('relatorio.relatorio-simplificado')->with([
            'exercicios'                => Exercicio::all(),
            'unidades_gestoras'         => UnidadeGestora::getOptions(),
            'unidades_administrativas'  => UnidadeAdministrativa::getOptions(),
            // 'naturezas_despesas' => $naturezas_despesas,
            'tipo_relatorio'            => $tipo_relatorio,
            'entidade'                  => $entidade,
            'acoes'                     => $acoes,
            'valores_totais'            => $valores_totais,
            'instituicao_id'            => $instituicao_id,
            'unidade_gestora_id'        => $unidade_gestora_id,
            'unidade_administrativa_id' => $unidade_administrativa_id,
            'exercicio_id'              => $exercicio_id,
            'exercicio'                 => $exercicio
        ]);
    }
    public function relatorioGeral(Request $request) 
    {
        $exercicio                  = isset($request->exercicio_id) ? Exercicio::find($request->exercicio_id) : Exercicio::first();
        $exercicio_id               = $exercicio->id;
        $instituicao_id             = 1;
        $valores_gerais             = [
            'valor_total' => 0,
            'valor_planejado' => 0,
            'saldo_a_planejar' => 0,
            'valor_total_custo_fixo' => 0,
            'valor_total_custo_variavel' => 0
        ];

        $acoes = AcaoTipo::whereHas('ploas', function ($query) use($exercicio_id, $instituicao_id) {
            $query->where('exercicio_id', $exercicio_id);
            $query->where('instituicao_id', $instituicao_id);
        })
        ->get();

        $unidades_gestoras = UnidadeGestora::where('instituicao_id', $instituicao_id)->get()->pluck('nome', 'id')->toArray();

        foreach($acoes as $acao) {
            $dados                  = [];
            $acao_id                = $acao->id;
            $natureza_controlador   = [];
            $naturezas_despesas     = [];
            $valor_total_acao       = 0;

            foreach($unidades_gestoras as $unidade_gestora_id => $unidade_gestora) {
                $callbackNaturezaDespesa = function ($query) use($exercicio_id, $instituicao_id, $acao_id, $unidade_gestora_id){
                    $query->whereHas('despesas', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $unidade_gestora_id) {
                        $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $unidade_gestora_id) {
                            $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $unidade_gestora_id) {
                                $query->where('unidade_gestora_id', $unidade_gestora_id);
                                $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $unidade_gestora_id) {
                                    $query->where('exercicio_id', $exercicio_id);
                                    $query->where('instituicao_id', $instituicao_id);
                                    $query->where('acao_tipo_id', $acao_id);
                                });
                            });
                        });
                    });
                };

                $callbackDespesa = function ($query) use($exercicio_id, $instituicao_id, $acao_id, $unidade_gestora_id) {
                    $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $unidade_gestora_id) {
                        $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $unidade_gestora_id) {
                            $query->where('unidade_gestora_id', $unidade_gestora_id);
                            $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id, $acao_id, $unidade_gestora_id) {
                                $query->where('exercicio_id', $exercicio_id);
                                $query->where('instituicao_id', $instituicao_id);
                                $query->where('acao_tipo_id', $acao_id);
                            });
                        });
                    });
                };

                $dados[$unidade_gestora] = [
                    'naturezas_despesas' => NaturezaDespesa::with('despesas')->whereHas('despesas', $callbackDespesa)
                        ->orWhereHas('subnaturezas_despesas', $callbackNaturezaDespesa)
                        ->with(['despesas' => $callbackDespesa])
                        ->get(),
                        'valor_total' => 0
                ];
            }

            foreach($dados as $index => $ug) {
                $valor_total_unidade_gestora = 0;
                if(count($ug['naturezas_despesas']) > 0) {
                    foreach($ug['naturezas_despesas'] as $key => $natureza_despesa) {
                        $valor_total_natureza_despesa = 0;

                        foreach($natureza_despesa->despesas as $despesa) {
                            if($despesa->tipo == 'despesa_fixa') {
                                $valores_gerais['valor_total_custo_fixo']           += $despesa->valor_total;
                            }
                            else {
                                $valores_gerais['valor_total_custo_variavel']       += $despesa->valor_total;
                            }

                            $valor_total_natureza_despesa += $despesa->valor_total;
                        }

                        if(!in_array($natureza_despesa->id, $natureza_controlador)) {
                            $naturezas_despesas[$natureza_despesa->id] = [
                                'nome_completo' => $natureza_despesa->nome_completo,
                                'valor_total' => $valor_total_natureza_despesa,
                                'subnaturezas_despesas' => []
                            ];
                        } else {
                            $naturezas_despesas[$natureza_despesa->id]['valor_total'] += $valor_total_natureza_despesa;
                        }
                            
                            
                        $natureza_controlador[] = $natureza_despesa->id;

                        $natureza_despesa['valor_total'] = $valor_total_natureza_despesa;
                        $valor_total_unidade_gestora += $valor_total_natureza_despesa;
                    }

                    foreach($ug['naturezas_despesas'] as $key => $natureza_despesa) {
                        foreach($natureza_despesa->subnaturezas_despesas as $subnatureza_despesa) {
                            $valor_total_subnatureza_despesa = 0;
                            foreach($subnatureza_despesa->despesas as $despesa) {
                                if($despesa->tipo == 'despesa_fixa') {
                                    $valores_gerais['valor_total_custo_fixo']           += $despesa->valor_total;
                                }
                                else {
                                    $valores_gerais['valor_total_custo_variavel']       += $despesa->valor_total;
                                }
    
                                $valor_total_subnatureza_despesa += $despesa->valor_total;
                            }
                            if(!in_array($subnatureza_despesa->id, $natureza_controlador)) {
                                $naturezas_despesas[$natureza_despesa->id]['subnaturezas_despesas'][$subnatureza_despesa->id] = [
                                    'nome_completo' => $subnatureza_despesa->nome_completo,
                                    'valor_total' => $valor_total_subnatureza_despesa
                                ];
                            } else {
                                $naturezas_despesas[$subnatureza_despesa->id]['valor_total'] += $valor_total_subnatureza_despesa;
                            }

                            $subnatureza_despesa['valor_total']     = $valor_total_subnatureza_despesa;
                            $valor_total_unidade_gestora            += $valor_total_subnatureza_despesa;
                        }
                    }
                }

                $dados[$index]['valor_total'] += $valor_total_unidade_gestora;
                $valor_total_acao += $valor_total_unidade_gestora;
            } 

            $acao['naturezas_despesas']                 = $naturezas_despesas;
            $acao['unidades_gestoras']                  = $dados;
            $acao['valor_total']                        = $valor_total_acao;
            $valores_gerais['valor_planejado']          += $valor_total_acao;
            $valores_gerais['valor_total']              += $acao->ploas()->where('exercicio_id', $exercicio_id)->where('instituicao_id', $instituicao_id)->sum('valor');
            $valores_gerais['saldo_a_planejar']         = $valores_gerais['valor_total'] - $valores_gerais['valor_planejado'];
            
        }

        // dd($acoes->toArray());
        // dd($valores_gerais);
        return view('relatorio.relatorio-geral')->with([
            'acoes'             => $acoes,
            'valores_gerais'    => $valores_gerais,
            'exercicio'         => $exercicio,
            'exercicios'                => Exercicio::all()
        ]);
    }
}
