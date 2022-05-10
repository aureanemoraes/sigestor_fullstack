<?php

namespace App\Http\Controllers;

use App\Models\CreditoPlanejado;
use App\Models\NaturezaCreditoPlanejado;
use App\Models\PlanoAcao;
use App\Models\CentroCusto;
use App\Models\PloaAdministrativa;
use App\Models\CreditoPlanejadoModelo;
use App\Models\Meta;
use App\Models\Despesa;
use App\Models\PloaGestora;
use App\Models\Ploa;
use App\Models\Exercicio;
use App\Models\UnidadeGestora;
use Illuminate\Http\Request;
use App\Http\Transformers\CreditoPlanejadoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreditoPlanejadoController extends Controller
{

	public function lista($despesa_id) {
		$despesa = Despesa::find($despesa_id);
		$creditos_planejados = CreditoPlanejado::where('despesa_id', $despesa_id)->get();

		return view('credito_planejado.lista')->with([
			'creditos_planejados' => $creditos_planejados,
			'despesa' => $despesa
		]);
	}

	public function autorizaGestora($id, Request $request) {
		$credito_planejado = CreditoPlanejado::find($id);
		$credito_planejado->unidade_gestora = $request->unidade_gestora;
		$credito_planejado->save();

		return view('credito_planejado.show')->with([
			'credito_planejado' => $credito_planejado,
			'tipo' => 1
		]); 
	}

	public function autorizaInstituicao($id, Request $request) {
		$credito_planejado = CreditoPlanejado::find($id);
		$credito_planejado->instituicao = $request->instituicao;
		$credito_planejado->save();

		return view('credito_planejado.show')->with([
			'credito_planejado' => $credito_planejado,
			'tipo' => 2
		]); 
	}

	public function index(Request $request)
	{
		if(isset($request->tipo) && isset($request->ploa)) {
			$tipo = $request->tipo;
			$exercicio_id = $request->ploa;
			$exercicio = Exercicio::find($exercicio_id);

			if($tipo == 2) {
				$credito_planejados = CreditoPlanejado::whereHas(
					'despesa', function ($query) use($exercicio_id) {
						$query->whereHas('ploa_administrativa', function($query) use($exercicio_id) {
							$query->whereHas('ploa_gestora', function($query) use($exercicio_id)  {
								$query->whereHas('ploa', function($query) use($exercicio_id) {
									$query->where('exercicio_id', $exercicio_id);
								});
							});
						});
					}
				)->get();

				$unidade_selecionada = null;
				$unidades_gestoras = null;
			} else if ($tipo == 1) {
				$unidade_selecionada = UnidadeGestora::find($request->unidade_gestora);
				$unidade_gestora_id = $unidade_selecionada->id;
				$unidades_gestoras = UnidadeGestora::all();

				$credito_planejados = CreditoPlanejado::whereHas(
					'despesa', function ($query) use($exercicio_id, $unidade_gestora_id) {
						$query->whereHas('ploa_administrativa', function($query) use($exercicio_id, $unidade_gestora_id) {
							$query->whereHas('ploa_gestora', function($query) use($exercicio_id, $unidade_gestora_id)  {
								$query->where('unidade_gestora_id', $unidade_gestora_id);
								$query->whereHas('ploa', function($query) use($exercicio_id) {
									$query->where('exercicio_id', $exercicio_id);
								});
							});
						});
					}
				)->get();

				
			}

			return view('credito_planejado.index')->with([
				'creditos_planejados' => $credito_planejados,
				'tipo' => $tipo,
				'exercicio' => $exercicio,
				'unidade_selecionada' => $unidade_selecionada,
				'unidades_gestoras' => $unidades_gestoras
			]);
		}
	}
		

	public function create(Request $request) {
        if(isset($request->despesa)) {
            $despesa = Despesa::find($request->despesa);

            return view('credito_planejado.create')->with([
               'despesa' => $despesa
            ]);
        }
		
	}

	public function store(Request $request)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$credito_planejado = CreditoPlanejadoTransformer::toInstance($request->all());
			$credito_planejado->save();

			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('loa_administrativa.index', ['ploa' => $credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->exercicio_id, 'unidade_administrativa' => $credito_planejado->despesa->ploa_administrativa->unidade_administrativa_id]);
	}

	public function show($id, Request $request)
	{
		// tipo 1: unidade gestora
		// tipo 2: instituição
		if(isset($request->tipo)) {
			$credito_planejado = CreditoPlanejado::find($id);
			if(isset($credito_planejado))
				return view('credito_planejado.show')->with([
					'credito_planejado' => $credito_planejado,
					'tipo' => $request->tipo
				]);
		}
	}

	public function edit($id, Request $request) {
		$credito_planejado = CreditoPlanejado::findOrFail($id);
		$ploa_administrativa = PloaAdministrativa::find($credito_planejado->ploa_administrativa_id);
		$credito_planejados_modelos = CreditoPlanejadoModelo::all();

		if(isset($credito_planejado->subnatureza_credito_planejado_id))
			$subnaturezas_credito_planejados = Subnatureza::where('natureza_credito_planejado_id', $credito_planejado->natureza_credito_planejado_id)->get();
		else
			$subnaturezas_credito_planejados = null;
			
		return view('credito_planejado.edit')->with([
			'credito_planejado' => $credito_planejado,
			'credito_planejados_modelos' => $credito_planejados_modelos,
			'ploa_administrativa' => $ploa_administrativa,
			'planos_acoes' => PlanoAcao::all(),
			'naturezas_credito_planejados' => NaturezaCreditoPlanejado::where('fav', 1)->get(),
			'subnaturezas_credito_planejados' => $subnaturezas_credito_planejados,
			'centros_custos' => CentroCusto::all(),
			'metas' => Meta::where('plano_acao_id', $credito_planejado->meta->plano_acao_id)->get()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$credito_planejado = CreditoPlanejado::find($id);

		if(isset($credito_planejado)) {
			try {
				DB::beginTransaction();
				$credito_planejado = CreditoPlanejadoTransformer::toInstance($request->all(), $credito_planejado);
				$credito_planejado->save();
	
				DB::commit();
			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('credito_planejado.index');
	}

	public function destroy($id)
	{
		$credito_planejado = CreditoPlanejado::find($id);
		$despesa_id = $credito_planejado->despesa_id;
		try {
			if(isset($credito_planejado)) {
				$credito_planejado->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('credito_planejado.lista',  $despesa_id);
	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'codigo_processo' => ['required'],
			'despesa_id' => ['required', 'exists:despesas,id'],
			'valor_solicitado' => ['required'],
			'comentarios' => ['nullable']
			// 'unique:creditos_planejados,despesa_id'
		]);

		if ($validator->fails()) {
			return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
		}
	}

	protected function rules($credito_planejado) {
		
	}
}
