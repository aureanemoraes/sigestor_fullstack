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
        $exercicio_id               = isset($request->exercicio_id) ? $request->exercicio_id : Exercicio::first()->id;
        $instituicao_id             = 1;
        $unidade_gestora_id         = isset($request->unidade_gestora_id) ? $request->unidade_gestora_id : null;
        $unidade_administrativa_id  = isset($request->unidade_administrativa_id) ? $request->unidade_administrativa_id : null;
        $tipo_relatorio             = isset($request->tipo_relatorio) ? $request->tipo_relatorio : 'institucional';

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

        $acoes = AcaoTipo::whereHas('ploas', function ($query) use($exercicio_id, $instituicao_id) {
            $query->where('exercicio_id', $exercicio_id);
            $query->where('instituicao_id', $instituicao_id);
            $query->whereHas('ploas_gestoras', function ($query) use($exercicio_id, $instituicao_id) {
                $query->whereHas('ploas_administrativas', function ($query) use($exercicio_id, $instituicao_id) {
                    $query->whereHas('despesas');
                });
            });
        })
        ->get();
        
        foreach($acoes as $acao) {
            $acao_id = $acao->id;
            $acao['naturezas_despesas'] = NaturezaDespesa::with('subnaturezas_despesas')->whereHas('despesas', function ($query) use($exercicio_id, $instituicao_id, $acao_id) {
                $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id, $acao_id) {
                    $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id, $acao_id) {
                        $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id, $acao_id) {
                            $query->where('exercicio_id', $exercicio_id);
                            $query->where('instituicao_id', $instituicao_id);
                            $query->where('acao_tipo_id', $acao_id);
                        });
                    });
                });
            })
            ->orWhereHas('subnaturezas_despesas',function ($query) use($exercicio_id, $instituicao_id, $acao_id){
                $query->whereHas('despesas', function ($query) use($exercicio_id, $instituicao_id, $acao_id) {
                    $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id, $acao_id) {
                        $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id, $acao_id) {
                            $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id, $acao_id) {
                                $query->where('exercicio_id', $exercicio_id);
                                $query->where('instituicao_id', $instituicao_id);
                                $query->where('acao_tipo_id', $acao_id);
                            });
                        });
                    });
                });
            })
            ->get();

            if(count($acao->naturezas_despesas) > 0) {
               // // definindo valores totais
                foreach($acao->naturezas_despesas as $natureza_despesa) {
                    $natureza_despesa->setAppends(['valores']);

                    $valores_totais['despesas_fixas']       += $natureza_despesa->despesas()->where('tipo', 'despesa_fixa')->sum('valor_total');
                    $valores_totais['despesas_variaveis']   += $natureza_despesa->despesas()->where('tipo', 'despesa_variavel')->sum('valor_total');

                    if(count($natureza_despesa->subnaturezas_despesas) > 0) {
                        foreach($natureza_despesa->subnaturezas_despesas as $subnatureza_despesa) {
                            $subnatureza_despesa->setAppends(['valores']);
                            $valores_totais['despesas_fixas']       += $subnatureza_despesa->despesas()->where('tipo', 'despesa_fixa')->sum('valor_total');
                            $valores_totais['despesas_variaveis']   += $subnatureza_despesa->despesas()->where('tipo', 'despesa_variavel')->sum('valor_total');
                        }
                    }
                }  
            }
        }

        // dd($acoes->toArray());

        // $naturezas_despesas = NaturezaDespesa::with('subnaturezas_despesas')->whereHas('despesas', function ($query) use($exercicio_id, $instituicao_id) {
        //     $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id) {
        //         $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id) {
        //             $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id) {
        //                 $query->where('exercicio_id', $exercicio_id);
        //                 $query->where('instituicao_id', $instituicao_id);
        //             });
        //         });
        //     });
        // })
        // ->orWhereHas('subnaturezas_despesas',function ($query) use($exercicio_id, $instituicao_id){
        //     $query->whereHas('despesas', function ($query) use($exercicio_id, $instituicao_id) {
        //         $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id) {
        //             $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id) {
        //                 $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id) {
        //                     $query->where('exercicio_id', $exercicio_id);
        //                     $query->where('instituicao_id', $instituicao_id);
        //                 });
        //             });
        //         });
        //     });
        // })
        // ->get();

        // // definindo valores totais
        // foreach($naturezas_despesas as $natureza_despesa) {
        //     $valores_totais['despesas_fixas']       += $natureza_despesa->despesas()->where('tipo', 'despesa_fixa')->sum('valor_total');
        //     $valores_totais['despesas_variaveis']   += $natureza_despesa->despesas()->where('tipo', 'despesa_variavel')->sum('valor_total');

        //     if(count($natureza_despesa->subnaturezas_despesas) > 0) {
        //         foreach($natureza_despesa->subnaturezas_despesas as $subnatureza_despesa) {
        //             $valores_totais['despesas_fixas']       += $subnatureza_despesa->despesas()->where('tipo', 'despesa_fixa')->sum('valor_total');
        //             $valores_totais['despesas_variaveis']   += $subnatureza_despesa->despesas()->where('tipo', 'despesa_variavel')->sum('valor_total');
        //         }
        //     }
        // }

   
        foreach($acoes as $acao) {
            $natureza_despesas_controlador = [];

            $acao->setAppends(['valores']);
            $valores_totais['matriz']               += $acao->valores['custeio']['total_matriz'] + $acao->valores['investimento']['total_matriz'];
            $valores_totais['planejado']            += $acao->valores['custeio']['total_planejado'] + $acao->valores['investimento']['total_planejado'];
            $valores_totais['saldo_a_planejar']     += $acao->valores['custeio']['saldo_a_planejar'] + $acao->valores['investimento']['saldo_a_planejar'];

            $dados[$acao->id] = [
                'nome_completo' => $acao->nome_completo
            ];

            if(count($acao->tipos) > 0) {
                foreach($acao->tipos as $tipo) {
                    $dados[$acao->id]['tipos'][$tipo] = [];
                }
            }
        }

        return view('relatorio.relatorio-simplificado')->with([
            'exercicios' => Exercicio::all(),
            'unidades_gestoras' => UnidadeGestora::getOptions(),
            'unidades_administrativas' => UnidadeAdministrativa::getOptions(),
            // 'naturezas_despesas' => $naturezas_despesas,
            'tipo_relatorio' => $tipo_relatorio,
            'entidade' => $entidade,
            'acoes' => $acoes,
            'valores_totais' => $valores_totais
        ]);
    }
}
