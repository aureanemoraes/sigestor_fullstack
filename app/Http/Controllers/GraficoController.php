<?php

namespace App\Http\Controllers;
use App\Models\Exercicio;
use App\Models\UnidadeGestora;
use App\Models\UnidadeAdministrativa;
use App\Models\AcaoTipo;
use App\Models\NaturezaDespesa;
use App\Models\Instituicao;
use App\Models\PlanoEstrategico;
use App\Models\PlanoAcao;
use App\Models\Objetivo;
use App\Models\EixoEstrategico;
use App\Models\Meta;
use Illuminate\Http\Request;

class GraficoController extends Controller
{
    public function matrizOrcamentaria(Request $request) 
    {
        $exercicios                 = Exercicio::all();
        $unidades_gestoras          = UnidadeGestora::all();
        $unidades_administrativas   = UnidadeAdministrativa::all();
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

        $acoes                      = AcaoTipo::whereHas('ploas', function ($query) use($exercicio_id, $instituicao_id, $unidade_gestora_id, $unidade_administrativa_id) {
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

        $valores_totais['matriz']               = 0;
        $valores_totais['planejado']            = 0;
        $valores_totais['saldo_a_planejar']     = 0;
        $valores_totais['liberado']             = 0;
        $valores_totais['despesas_fixas']       = 0;
        $valores_totais['despesas_variaveis']   = 0;

        $datasets_acoes         = [];
        $total_planejado_ploa   = 0;

        if(count($acoes) > 0) {
            foreach($acoes as $acao) {
                $acao_id            = $acao->id;
                $callbackDespesa = function ($query) use($exercicio_id, $instituicao_id, $acao_id,  $unidade_gestora_id, $unidade_administrativa_id) {
                    $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id, $acao_id,  $unidade_gestora_id, $unidade_administrativa_id) {
                        if(isset($unidade_administrativa_id)) {
                            $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                        }
                        $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id, $acao_id,  $unidade_gestora_id, $unidade_administrativa_id) {
                            if(isset($unidade_gestora_id)) {
                                $query->where('unidade_gestora_id', $unidade_gestora_id);
                            }
                            $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id, $acao_id,  $unidade_gestora_id, $unidade_administrativa_id) {
                                $query->where('exercicio_id', $exercicio_id);
                                $query->where('instituicao_id', $instituicao_id);
                                $query->where('acao_tipo_id', $acao_id);
                            });
                        });
                    });
                };
                
                $callbackNaturezaDespesa = function ($query) use($exercicio_id, $instituicao_id, $acao_id,  $unidade_gestora_id, $unidade_administrativa_id){
                    $query->whereHas('despesas', function ($query) use($exercicio_id, $instituicao_id, $acao_id,  $unidade_gestora_id, $unidade_administrativa_id) {
                        $query->whereHas('ploa_administrativa', function ($query) use($exercicio_id, $instituicao_id, $acao_id,  $unidade_gestora_id, $unidade_administrativa_id) {
                            if(isset($unidade_administrativa_id)) {
                                $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                            }
                            $query->whereHas('ploa_gestora', function ($query) use($exercicio_id, $instituicao_id, $acao_id,  $unidade_gestora_id, $unidade_administrativa_id) {
                                if(isset($unidade_gestora_id)) {
                                    $query->where('unidade_gestora_id', $unidade_gestora_id);
                                }
                                $query->whereHas('ploa', function ($query) use($exercicio_id, $instituicao_id, $acao_id,  $unidade_gestora_id, $unidade_administrativa_id) {
                                    $query->where('exercicio_id', $exercicio_id);
                                    $query->where('instituicao_id', $instituicao_id);
                                    $query->where('acao_tipo_id', $acao_id);
                                });
                            });
                        });
                    });
                };

                $acao['naturezas_despesas']     = NaturezaDespesa::whereHas('despesas', $callbackDespesa)
                    ->orWhereHas('subnaturezas_despesas', $callbackNaturezaDespesa)
                    ->with(['despesas' => $callbackDespesa])
                    ->get();
                $acao['total_custo_fixo']       = 0;
                $acao['total_custo_variavel']   = 0;
                $acao['total']                  = 0;

                if(count($acao['naturezas_despesas']) > 0) {
                    $coringa_tipo_acao                                    = $acao;

                    foreach($acao['naturezas_despesas'] as $natureza_despesa) {
                        $natureza_despesa['custo_fixo']         = 0;
                        $natureza_despesa['custo_variavel']     = 0;
                        $natureza_despesa['total']              = 0;

                        foreach($natureza_despesa->despesas as $despesa) {
                            $despesa->setAppends(['valor_recebido']);
                            $valores_totais['liberado']                    += $despesa->valor_recebido;

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
                                    $despesa->setAppends(['valor_recebido']);
                                    $valores_totais['liberado']                         += $despesa->valor_recebido;

                                    if($despesa->tipo == 'despesa_fixa') {
                                        $subnatureza_despesa['custo_fixo']              += $despesa->valor_total;
                                        $valores_totais['despesas_fixas']               += $despesa->valor_total;
                                    }
                                    else {
                                        $subnatureza_despesa['custo_variavel']          += $despesa->valor_total;
                                        $valores_totais['despesas_variaveis']           += $despesa->valor_total;
                                    }
                                }
                                $subnatureza_despesa['total'] += $subnatureza_despesa['custo_fixo'] + $subnatureza_despesa['custo_variavel'] ;

                                $coringa_tipo_acao['total_custo_fixo']            += $subnatureza_despesa['custo_fixo'];
                                $coringa_tipo_acao['total_custo_variavel']        += $subnatureza_despesa['custo_variavel'];
                                $coringa_tipo_acao['total']                       += $subnatureza_despesa['total'];
                            }
                        }

                        $coringa_tipo_acao['total_custo_fixo']            += $natureza_despesa['custo_fixo'];
                        $coringa_tipo_acao['total_custo_variavel']        += $natureza_despesa['custo_variavel'];
                        $coringa_tipo_acao['total']                       += $natureza_despesa['total'];
                    }  

                }
            }

            $total_planejado_ploa = $valores_totais['despesas_fixas'] + $valores_totais['despesas_variaveis'];

            // dd($acoes->toArray());

            foreach($acoes as $acao) {
                $total_planejado    = $acao->total;
                $porcentagem        =  number_format(($total_planejado/$total_planejado_ploa)*100, 1);
                $r = rand(0, 255);
                $g = rand(0, 255);
                $b = rand(0, 255);

                $datasets_acoes[] = [
                    "label" => $acao->codigo . ' (' .formatCurrency($total_planejado) . ')',
                    'backgroundColor' => ["rgba($r, $g, $b)"],
                    'data' => [$porcentagem]
                ];
            }

            $r_fixo = rand(0, 255);
            $g_fixo = rand(0, 255);
            $b_fixo = rand(0, 255);
            $porcentagem_fixo = number_format(($valores_totais['despesas_fixas']/$total_planejado_ploa)*100, 2);

            $r_variavel = rand(0, 255);
            $g_variavel = rand(0, 255);
            $b_variavel = rand(0, 255);

            $porcentagem_variavel = number_format(($valores_totais['despesas_variaveis']/$total_planejado_ploa)*100, 2);

            $datasets_despesas = [
                [
                    "label" => 'DESPESAS FIXAS (' . formatCurrency($valores_totais['despesas_fixas']) . ')',
                    'backgroundColor' => ["rgba($r_fixo, $g_fixo, $b_fixo)"],
                    'data' => [$porcentagem_fixo]
                ],
                [
                    "label" => 'DESPESAS VARIÁVEIS (' . formatCurrency($valores_totais['despesas_variaveis']) . ')',
                    'backgroundColor' => ["rgba($r_variavel, $g_variavel, $b_variavel)"],
                    'data' => [$porcentagem_variavel]
                ], 
            ];

            

                // dd($valores_totais);

            $r_planejado = rand(0, 255);
            $g_planejado = rand(0, 255);
            $b_planejado = rand(0, 255);
            $porcentagem_planejado = "100";

            $r_liberado = rand(0, 255);
            $g_liberado = rand(0, 255);
            $b_liberado = rand(0, 255);

            $porcentagem_liberado = number_format(($valores_totais['liberado']/$total_planejado_ploa)*100, 2);

            $datasets_recursos = [
                [
                    "label" => 'VALOR PLANEJADO (' . formatCurrency($total_planejado_ploa) . ')',
                    'backgroundColor' => ["rgba($r_planejado, $g_planejado, $b_planejado)"],
                    'data' => [$porcentagem_planejado]
                ],
                [
                    "label" => 'VALOR LIBERADO (' . formatCurrency($valores_totais['planejado']) . ')',
                    'backgroundColor' => ["rgba($r_liberado, $g_liberado, $b_liberado)"],
                    'data' => [$porcentagem_liberado]
                ], 
            ];
        }

        $options = ['maintainAspectRatio' => false, 'scales' => [
                'yAxes' => [
                    'min' => 0,
                    'max' => 100,
                    'ticks' => [
                        'stepSize' => 10,
                    ],
                    'grid' => [
                        'display' => false
                    ]
                ],
                
            ],
        ];

        if(!isset($datasets_acoes))
            $datasets_acoes[] = [
                "label" => '',
                'backgroundColor' => ["rgba(0, 0,0)"],
                'data' => [0]
            ];

        if(!isset($datasets_despesas))
            $datasets_despesas[] = [
                "label" => '',
                'backgroundColor' => ["rgba(0, 0,0)"],
                'data' => [0]
            ];

        if(!isset($datasets_recursos))
            $datasets_recursos[] = [
                "label" => '',
                'backgroundColor' => ["rgba(0, 0,0)"],
                'data' => [0]
            ];

        $acoes = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 600, 'height' => 500])
        ->labels(['AÇÕES'])
        ->datasets($datasets_acoes)
        ->options($options);

        $despesas = app()->chartjs
        ->name('barChartTestAA')
        ->type('bar')
        ->size(['width' => 300, 'height' => 250])
        ->labels(['DESPESAS'])
        ->datasets($datasets_despesas)
        ->options($options);

        $recursos = app()->chartjs
        ->name('aaa')
        ->type('bar')
        ->size(['width' => 300, 'height' => 250])
        ->labels(['PLANEJADO E LIBERADO'])
        ->datasets($datasets_recursos)
        ->options($options);


        return view('public.graficos.matriz_orcamentaria')->with([
            'acoes'                     => isset($acoes) ? $acoes : null, 
            'despesas'                  => isset($despesas) ? $despesas : null, 
            'recursos'                  => isset($recursos) ? $recursos : null,
            'exercicios'                => $exercicios,
            'unidades_gestoras'         => $unidades_gestoras,
            'unidades_administrativas'  => $unidades_administrativas,
            'exercicio'                 => $exercicio,
            'tipo_relatorio'            => $tipo_relatorio,
            'entidade'                  => $entidade,
            'instituicao_id'            => $instituicao_id,
            'unidade_gestora_id'        => $unidade_gestora_id,
            'unidade_administrativa_id' => $unidade_administrativa_id,
            'exercicio_id'              => $exercicio_id,
        ]);
    }

    public function matrizEstrategica(Request $request) 
    {
        $planos_estrategicos                = PlanoEstrategico::all();
        $planos_acoes                       = PlanoAcao::all();
        $eixos_estrategicos                 = EixoEstrategico::all();
        $objetivos                          = Objetivo::all();
        $plano_estrategico                  = isset($request->plano_estrategico_id) ? PlanoEstrategico::find($request->plano_estrategico_id) : PlanoEstrategico::first();
        $plano_estrategico_id               = $plano_estrategico->id;
        $plano_acao                         = isset($request->plano_acao_id) ? PlanoAcao::find($request->plano_acao_id) : $plano_estrategico->eixos_estrategicos()->first();
        $plano_acao_id                      = $plano_acao->id;
        $eixo_estrategico                   = isset($request->eixo_estrategico_id) ? EixoEstrategico::find($request->eixo_estrategico_id) : null;
        $eixo_estrategico_id                = isset($request->eixo_estrategico_id) ? $request->eixo_estrategico_id : null;
        $objetivo_id                        = isset($request->objetivo_id) ? $request->objetivo_id : null;
        $instituicao_id                     = 1;
        $data_objetivos                     = [];
        $data_eixos_estrategicos            = [];
        $objetivos_controlador              = [];
        $eixos_estrategicos_controlador     = [];
        $porcentagem_geral_metas            = 0;

        $metas_estrategicas = Meta::where('plano_acao_id', $plano_acao_id);
        if(isset($eixo_estrategico_id))
            $metas_estrategicas = $metas_estrategicas->whereHas('objetivo', function ($query) use ($eixo_estrategico_id, $plano_estrategico_id) {
                $query->whereHas('dimensao', function ($query) use ($eixo_estrategico_id, $plano_estrategico_id) {
                    $query->whereHas('eixo_estrategico', function ($query) use ($eixo_estrategico_id, $plano_estrategico_id) {
                        if(isset($eixo_estrategico_id))
                            $query->where('id', $eixo_estrategico_id);
                        $query->where('plano_estrategico_id', $plano_estrategico_id);
                    });
                });
            });

        if(isset($objetivo_id))
            $metas_estrategicas = $metas_estrategicas->where('objetivo_id', $objetivo_id);

        $metas_estrategicas = $metas_estrategicas->get();

        foreach($metas_estrategicas as $meta_estrategica) {
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);

            $dataset_metas[] = [
                "label" => $meta_estrategica->nome,
                'backgroundColor' => ["rgba($r,$g,$b)"],
                'data' => [$meta_estrategica->porcentagem_atual]
            ];

            if(!in_array($meta_estrategica->objetivo_id, $objetivos_controlador)) {
                $data_objetivos[] = $meta_estrategica->objetivo;
                $objetivos_controlador[] = $meta_estrategica->objetivo_id;

                if(!in_array($meta_estrategica->objetivo->dimensao->eixo_estrategico_id, $eixos_estrategicos_controlador)) {
                    $data_eixos_estrategicos[] = $meta_estrategica->objetivo->dimensao->eixo_estrategico;
                    $eixos_estrategicos_controlador[] = $meta_estrategica->objetivo->dimensao->eixo_estrategico_id;
                }
            }
        }

        foreach($data_objetivos as $objetivo) {
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);

            $dataset_objetivos[] = [
                "label" => $objetivo->nome,
                'backgroundColor' => ["rgba($r,$g,$b)"],
                'data' => [$objetivo->porcentagem_atual]
            ];
        }

        foreach($data_eixos_estrategicos as $ee) {
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);

            $porcentagem_geral_metas += $ee->porcentagem_atual;

            $dataset_eixo_estrategicos[] = [
                "label" => $ee->nome,
                'backgroundColor' => ["rgba($r,$g,$b)"],
                'data' => [$ee->porcentagem_atual]
            ];
        }

        $options = ['maintainAspectRatio' => false, 'scales' => [
                'yAxes' => [
                    'min' => 0,
                    'max' => 100,
                    'ticks' => [
                        'stepSize' => 10,
                    ],
                    'grid' => [
                        'display' => false
                    ]
                ],
                
            ],
        ];

        if(!isset($dataset_metas))
            $dataset_metas[] = [
                "label" => '',
                'backgroundColor' => ["rgba(0, 0,0)"],
                'data' => [0]
            ];

        if(!isset($dataset_objetivos))
            $dataset_objetivos[] = [
                "label" => '',
                'backgroundColor' => ["rgba(0, 0,0)"],
                'data' => [0]
            ];

        if(!isset($dataset_eixo_estrategicos))
            $dataset_eixo_estrategicos[] = [
                "label" => '',
                'backgroundColor' => ["rgba(0, 0,0)"],
                'data' => [0]
            ];

        if (!isset($eixo_estrategico_id)) {
            $grafico = app()->chartjs
            ->name('bb')
            ->type('bar')
            ->size(['width' => 600, 'height' => 350])
            ->labels(['EIXOS ESTRATÉGICOS'])
            ->datasets($dataset_eixo_estrategicos)
            ->options($options);
        } else {
            $grafico = app()->chartjs
            ->name('bb')
            ->type('bar')
            ->size(['width' => 600, 'height' => 350])
            ->labels(['OBJETIVOS ESTRATÉGICOS'])
            ->datasets($dataset_objetivos)
            ->options($options);    
        }
        
        return view('public.graficos.matriz_estrategica')->with([
            'grafico'                         => isset($grafico) ? $grafico : null, 
            'planos_estrategicos'                   => $planos_estrategicos,
            'planos_acoes'                          => $planos_acoes,
            'eixos_estrategicos'                    => $eixos_estrategicos,
            'objetivos'                             => $objetivos,
            'plano_estrategico'                     => $plano_estrategico,
            'plano_acao'                            => $plano_acao,
            'plano_acao_id'                         => $plano_acao_id,
            'eixo_estrategico'                      => $eixo_estrategico,
            'eixo_estrategico_id'                   => $eixo_estrategico_id,
            'plano_estrategico_id'                  => $plano_estrategico_id,
            'objetivo_id'                           => $objetivo_id,
            'data_eixos_estrategicos'               => $data_eixos_estrategicos,
            'data_objetivos'                        => $data_objetivos,
            'metas_estrategicas'                    => $metas_estrategicas,
            'porcentagem_geral_metas'               => $porcentagem_geral_metas
        ]);
    }
}


//     $piechartjs = app()->chartjs
//     ->name('pieChartTest')
//     ->type('doughnut')
//     ->size(['width' => 200, 'height' => 100])
//     ->labels(['Label x', 'Label y'])
//     ->datasets([
//         [
//             'backgroundColor' => ['#FF6384', '#36A2EB'],
//             'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
//             'data' => [69, 59]
//         ]
//     ])
//    ->options(['maintainAspectRatio' => false, 'scales' => [
//                 'y' => [
//                     'min' => 0,
//                     'max' => 100
//                 ],
//             ],
//         ]);

      // $linechartjs = app()->chartjs
        // ->name('lineChartTest')
        // ->type('line')
        // ->size(['width' => 600, 'height' => 200])
        // ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
        // ->datasets([
        //     [
        //         "label" => "My First dataset",
        //         'backgroundColor' => "rgba(38, 185, 154, 0.31)",
        //         'borderColor' => "rgba(38, 185, 154, 0.7)",
        //         "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
        //         "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
        //         "pointHoverBackgroundColor" => "#fff",
        //         "pointHoverBorderColor" => "rgba(220,220,220,1)",
        //         'data' => [65, 59, 80, 81, 56, 55, 40],
        //     ],
        //     [
        //         "label" => "My Second dataset",
        //         'backgroundColor' => "rgba(38, 185, 154, 0.31)",
        //         'borderColor' => "rgba(38, 185, 154, 0.7)",
        //         "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
        //         "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
        //         "pointHoverBackgroundColor" => "#fff",
        //         "pointHoverBorderColor" => "rgba(220,220,220,1)",
        //         'data' => [12, 33, 44, 44, 55, 23, 40],
        //     ]
        // ])
        // ->options(['maintainAspectRatio' => false, 'scales' => [
        //     'yAxes' => [
        //         'min' => 0,
        //         'max' => 100
        //     ],
        // ],]);
