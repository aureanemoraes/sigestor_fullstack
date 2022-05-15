<?php

namespace App\Http\Controllers;

use App\Models\Remanejamento;
use App\Models\RemanejamentoDestinatario;
use App\Models\Exercicio;
use App\Models\UnidadeGestora;
use App\Models\Despesa;
use App\Models\AcaoTipo;
use App\Models\NaturezaDespesa;
use App\Models\UnidadeAdministrativa;
use App\Http\Transformers\DespesaTransformer;
use App\Http\Transformers\RemanejamentoDestinatarioTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemanejamentoDestinatarioController extends Controller
{
    public function create(Request $request)
	{
		if(isset($request->ploa) && isset($request->unidade_gestora) && isset($request->remanejamento)) {
			$exercicio = Exercicio::find($request->ploa);
            $remanejamento = Remanejamento::find($request->remanejamento)->setAppends(['valor_disponivel']);
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
                ->whereNotIn('despesas.id', [$remanejamento->despesa_remetente_id])->get();

                $despesas_filtradas = [];
    
                $acoes = AcaoTipo::whereHas('ploas', function($query) use($unidade_administrativa_id, $exercicio, $remanejamento) {
                    $query->whereHas('ploas_gestoras', function($query) use($unidade_administrativa_id, $exercicio, $remanejamento) {
                        $query->whereHas('ploas_administrativas', function($query) use($unidade_administrativa_id, $exercicio, $remanejamento) {
                            $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                            $query->whereHas('despesas', function ($query) use($unidade_administrativa_id, $exercicio, $remanejamento){
                                $query->whereNotIn('despesas.id', [$remanejamento->despesa_remetente_id]);
                                $query->doesntHave('creditos_planejados');
                                $query->whereHas('ploa_administrativa', function($query) use($unidade_administrativa_id, $exercicio) {
                                    $query->where('unidade_administrativa_id', $unidade_administrativa_id);
                                    $query->whereHas('ploa_gestora', function($query) use($unidade_administrativa_id, $exercicio) {
                                        $query->whereHas('ploa', function($query) use($unidade_administrativa_id, $exercicio) {
                                            $query->where('exercicio_id', $exercicio->id);
                                        });
                                    });
                                });
                            });
                        });
                    });
                })
                ->get();
    
                $naturezas_despesas = NaturezaDespesa::whereHas('despesas', function ($query) use($unidade_administrativa_id, $exercicio, $remanejamento){
                    $query->whereNotIn('despesas.id', [$remanejamento->despesa_remetente_id]);
                    $query->doesntHave('creditos_planejados');
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

			return view('remanejamento_destinatario.create')->with([
                'acoes' => isset($acoes) ? $acoes : [],
                'naturezas_despesas' => isset($naturezas_despesas) ? $naturezas_despesas : [],
				'exercicio' => $exercicio,
				'unidades_gestoras' => $unidades_gestoras,
				'unidades_administrativas' => $unidades_administrativas,
                'unidade_administrativa_selecionada' => $unidade_administrativa_selecionada,
				'unidade_selecionada' => $unidade_selecionada,
                'remanejamento' => $remanejamento
			]);
		}
	}

    public function store(Request $request) {
        if(count($request->valor_remanejamento) > 0) {
            foreach($request->valor_remanejamento as $despesa_id => $valor_remanejamento) {
                if(isset($valor_remanejamento) && $valor_remanejamento > 0) {
                    $despesa = Despesa::find($despesa_id);
                    if(isset($despesa)) {
			            DB::beginTransaction();

                        $inputs_remanejamento['valor_remanejamento'] = $valor_remanejamento;
                        $inputs_remanejamento['remanejamento_id'] = $request->remanejamento_id;
                        $inputs_remanejamento['despesa_destinatario_id'] = $despesa->id;
                        $remanejamento_destinatario = RemanejamentoDestinatarioTransformer::toInstance($inputs_remanejamento);
                        $remanejamento_destinatario->save();

                        $inputs_despesa['valor'] = $request->valor[$despesa_id];
                        $inputs_despesa['fields'] = isset($request->fields[$despesa_id]) ? $request->fields[$despesa_id] : null;
                        $despesa = DespesaTransformer::toInstance($inputs_despesa, $despesa);
                        $despesa->save();

			            DB::commit();
                    }
                }
            }
        }
    }

}
