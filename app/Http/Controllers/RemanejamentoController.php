<?php

namespace App\Http\Controllers;

use App\Models\Remanejamento;
use App\Models\Exercicio;
use App\Models\UnidadeGestora;
use App\Models\Despesa;
use App\Models\AcaoTipo;
use App\Models\NaturezaDespesa;
use App\Models\UnidadeAdministrativa;
use App\Models\RemanejamentoDestinatario;
use App\Http\Transformers\RemanejamentoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Transformers\DespesaTransformer;

class RemanejamentoController extends Controller
{
    public function historico($despesa_id, $tipo) 
    {
        $despesa = Despesa::find($despesa_id);
        if($tipo == 1) {
            $remanejamentos_destinatarios = RemanejamentoDestinatario::whereHas('remanejamento', function ($query) use($despesa_id) {
                $query->where('despesa_remetente_id', $despesa_id)->whereNotNull('unidade_gestora_id');
            })->OrWhere('despesa_destinatario_id', $despesa_id)->get();
        } else if($tipo == 2) {
            $remanejamentos_destinatarios = RemanejamentoDestinatario::whereHas('remanejamento', function ($query) use($despesa_id) {
                $query->where('despesa_remetente_id', $despesa_id)->whereNotNull('instituicao_id');
            })->OrWhere('despesa_destinatario_id', $despesa_id)->get();
        }

        return view('remanejamento.historico')->with([
            'remanejamentos_destinatarios' => $remanejamentos_destinatarios,
            'despesa_id' => $despesa_id,
            'despesa' => $despesa
        ]);
    }
 
    public function index(Request $request)
	{
		if(isset($request->ploa) && isset($request->unidade_gestora)) {
			$exercicio = Exercicio::find($request->ploa);
			$unidade_gestora_id= $request->unidade_gestora;
			$unidade_selecionada = UnidadeGestora::find($request->unidade_gestora);
			$unidades_gestoras = UnidadeGestora::all();
            $unidade_administrativa_selecionada = null;
            if(isset($request->unidade_administrativa))
                $unidade_administrativa_selecionada = UnidadeAdministrativa::where('id', $request->unidade_administrativa)->where('unidade_gestora_id', $unidade_gestora_id)->first();
            $unidades_administrativas = UnidadeAdministrativa::where('unidade_gestora_id', $unidade_gestora_id)->get();

            if(isset($unidade_administrativa_selecionada)) {
                $unidade_administrativa_id = $unidade_administrativa_selecionada->id;
                $despesas = Despesa::whereHas('ploa_administrativa', function ($query) use($unidade_gestora_id, $unidade_administrativa_id){
                    $query->whereHas('ploa_gestora', function ($query) use($unidade_gestora_id){
                        $query->where('unidade_gestora_id', $unidade_gestora_id);
                    });
                    $query ->where('unidade_administrativa_id', $unidade_administrativa_id);
                })
                ->get();
    
                $despesas_filtradas = [];
    
                foreach($despesas as $despesa) {
                    if(count($despesa->creditos_planejados) == 0) {
                        $despesas_filtradas[] = $despesa;
                    } else if (count($despesa->creditos_planejados) > 0) {
                        $despesa_invalida = $despesa->creditos_planejados()->whereIn('unidade_gestora', ['deferido', 'pendente'])->whereIn('instituicao', ['deferido', 'pendente'])->exists();
    
                        if(!$despesa_invalida)
                            $despesas_filtradas[] = $despesa;
                    }
                }
    
                $despesas_filtradas = (object) $despesas_filtradas;
    
                $acoes = AcaoTipo::whereHas('ploas', function($query) use($unidade_administrativa_id, $exercicio) {
                    $query->where('exercicio_id', $exercicio->id);
                    $query->whereHas('ploas_gestoras', function($query) use($unidade_administrativa_id, $exercicio) {
                        $query->whereHas('ploas_administrativas', function($query) use($unidade_administrativa_id, $exercicio) {
                            $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                            $query->whereHas('despesas');
                        });
                    });
                })
                ->get();
    
                $naturezas_despesas = NaturezaDespesa::whereHas('despesas', function ($query) use($unidade_administrativa_id, $exercicio){
                    $query->whereHas('ploa_administrativa', function($query) use($unidade_administrativa_id, $exercicio) {
                        $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                        $query->whereHas('ploa_gestora', function($query) use($unidade_administrativa_id, $exercicio) {
                            $query->whereHas('ploa', function($query) use($unidade_administrativa_id, $exercicio) {
                                $query->where('exercicio_id', $exercicio->id);
                            });
                        });
                    });
                })
                ->get();
            }

			return view('remanejamento.index')->with([
				'despesas' => isset($despesas_filtradas) ? $despesas_filtradas : [],
                'acoes' => isset($acoes) ? $acoes : [],
                'naturezas_despesas' => isset($naturezas_despesas) ? $naturezas_despesas : [],
				'exercicio' => $exercicio,
				'unidades_gestoras' => $unidades_gestoras,
				'unidades_administrativas' => $unidades_administrativas,
                'unidade_administrativa_selecionada' => $unidade_administrativa_selecionada,
				'unidade_selecionada' => $unidade_selecionada
			]);
		}
	}

    public function create(Request $request)
    {
        if(isset($request->despesa) && isset($request->tipo)) {
            // tipos: 1 - unidade gestoras | 2 - instituicao
            $despesa_remetente = Despesa::find($request->despesa);
            $unidade_gestora_id = $despesa_remetente->ploa_administrativa->ploa_gestora->unidade_gestora_id;
            $unidades_administrativas = UnidadeAdministrativa::where('unidade_gestora_id', $unidade_gestora_id)->get();

            return view('remanejamento.create')->with([
                'despesa_remetente' => $despesa_remetente->setAppends(['remanejamento_id']),
                'unidades_administrativas' => $unidades_administrativas,
                'tipo' => $request->tipo
            ]);
        }
    }

    public function store(Request $request)
    {
        $ploa = $request->exercicio_id;

		try {
			DB::beginTransaction();
			$remanejamento = RemanejamentoTransformer::toInstance($request->all());
            $despesa = Despesa::find($remanejamento->despesa_remetente_id);
            $despesa = DespesaTransformer::toInstance($request->all(), $despesa);

            $despesa->save();
			$remanejamento->save();

			DB::commit();

            $ploa = $remanejamento->despesa_remetente->exercicio_id;
            $unidade_gestora = $remanejamento->despesa_remetente->ploa_administrativa->unidade_administrativa->unidade_gestora_id;
            $unidade_administrativa = $remanejamento->despesa_remetente->ploa_administrativa->unidade_administrativa_id;

            return redirect()->route('remanejamento.index', [
                'tipo' => 1, 
                'ploa' => $ploa, 
                'unidade_gestora' => $unidade_gestora,
                'unidade_administrativa' => $unidade_administrativa
            ]);
		} catch (Exception $ex) {
			DB::rollBack();
		}
    }

    public function show($id)
    {
        $remanejamento = Remanejamento::find($id);

        if(isset($remanejamento)) {
            return view('remanejamento.show')->with([
                'remanejamento' => $remanejamento
            ]);
        }
    }

    public function edit(Remanejamento $certidaoCredito)
    {
        //
    }

    public function update(Request $request, Remanejamento $certidaoCredito)
    {
        //
    }

    public function destroy(Remanejamento $certidaoCredito)
    {
        //
    }
}
