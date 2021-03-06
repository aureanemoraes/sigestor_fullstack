<?php

namespace App\Http\Controllers;

use App\Models\PloaGestora;
use App\Models\Exercicio;
use App\Models\Programa;
use App\Models\FonteTipo;
use App\Models\AcaoTipo;
use App\Models\Instituicao;
use App\Models\UnidadeGestora;
use App\Models\UnidadeAdministrativa;
use App\Models\PloaAdministrativa;
use App\Models\Ploa;
use Illuminate\Http\Request;
use App\Http\Transformers\PloaGestoraTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PloaGestoraController extends Controller
{
	public function distribuicao($unidade_administrativa_id = null, $exercicio_id = null)
	{
        if(isset($unidade_administrativa_id) && isset($exercicio_id)) {
			$exercicio_selecionado = Exercicio::find($exercicio_id);
			$unidade_administrativa = UnidadeAdministrativa::find($unidade_administrativa_id);
			$unidade_gestora_id = $unidade_administrativa->unidade_gestora_id;

            $ploas_administrativas = PloaAdministrativa::whereHas(
				'ploa_gestora', function ($query) use ($exercicio_id) {
					$query->whereHas(
					'ploa', function ($query) use ($exercicio_id) {
						$query->where('exercicio_id', $exercicio_id);
					});
				}
			)->where('unidade_administrativa_id', $unidade_administrativa_id)->get();

			$total_ploa = $ploas_administrativas->sum('valor');

			$programas_ploa = Programa::whereHas(
				'ploas', function ($query) use($unidade_administrativa_id, $exercicio_id) {
						$query->where('exercicio_id', $exercicio_id);
						$query->whereHas('ploas_gestoras', function($query) use ($unidade_administrativa_id) {
							$query->whereHas('ploas_administrativas', function($query) use ($unidade_administrativa_id) {
								$query->where('unidade_administrativa_id', $unidade_administrativa_id);
							});
						});
				}
			)->get();

			$programas = Programa::whereHas(
				'ploas', function ($query) use($unidade_gestora_id, $exercicio_id) {
					$query->where('exercicio_id', $exercicio_id);
					$query->whereHas('ploas_gestoras', function($query) use ($unidade_gestora_id) {
						$query->where('unidade_gestora_id', $unidade_gestora_id);
					});
				}
			)->get();

			$fontes = FonteTipo::whereHas(
				'ploas', function ($query) use($unidade_gestora_id, $exercicio_id) {
					$query->where('exercicio_id', $exercicio_id);
					$query->whereHas('ploas_gestoras', function($query) use ($unidade_gestora_id) {
						$query->where('unidade_gestora_id', $unidade_gestora_id);
					});
				}
			)->get();

			$acoes = AcaoTipo::whereHas(
				'ploas', function ($query) use($unidade_gestora_id, $exercicio_id) {
					$query->where('exercicio_id', $exercicio_id);
					$query->whereHas('ploas_gestoras', function($query) use ($unidade_gestora_id) {
						$query->where('unidade_gestora_id', $unidade_gestora_id);
					});
				}
			)->get();

			// foreach($programas_ploa as $programa) {
			// 	if(count($programa->ploas) > 0) {
			// 		$programa->valor_total = 0;
			// 		foreach($programa->ploas as $ploa) {
			// 			$programa->valor_total += isset($ploa->ploa_gestora->ploa_administrativa) ? $ploa->ploa_gestora->ploa_administrativa->valor : 0;
			// 		}
			// 	}
			// }

            return view('ploa_gestora.distribuicao')->with([
                'programas_ploa' => $programas_ploa,
				'ploas_administrativas' => $ploas_administrativas,
                'exercicios' => Exercicio::all(),
                'programas' => $programas,
                'fontes' => $fontes,
                'acoes' => $acoes,
                'instituicoes' => Instituicao::all(),
                'total_ploa' => $total_ploa,
                'unidade_selecionada' => $unidade_administrativa,
				'unidades_administrativas' => UnidadeAdministrativa::all(),
				'exercicio_selecionado' => $exercicio_selecionado
            ]);
        } else {
            return view('ploa_gestora.distribuicao')->with([
							'unidades_administrativas' => UnidadeAdministrativa::all(),
							'exercicios' => Exercicio::all()						
						]);
        }
		
	}
	
	public function opcoes($dimensao_id)
	{
		return PloaGestora::select('id', 'nome as text')->where('dimensao_id', $dimensao_id)->where('ativo', 1)->get();
	}

	public function index($unidade_gestora_id = null, $exercicio_id = null)
	{
		$valor_distribuido = 0;
		$valor_a_distribuir = 0;
		$valor_planejado = 0;
		$valor_a_planejar = 0;
		$total_ploa = 0;

        if(isset($unidade_gestora_id) && isset($exercicio_id)) {
			$exercicio_selecionado = Exercicio::find($exercicio_id);

            $ploas_gestoras = PloaGestora::whereHas(
				'ploa', function ($query) use ($exercicio_id) {
					$query->where('exercicio_id', $exercicio_id);
				}
			)->where('unidade_gestora_id', $unidade_gestora_id)->get();

			$total_ploa = $ploas_gestoras->sum('valor');

			if(count($ploas_gestoras) > 0) {
				foreach($ploas_gestoras as $ploa_gestora) {
					if(count($ploa_gestora->ploas_administrativas) > 0)
						$valor_distribuido += $ploa_gestora->ploas_administrativas()->sum('valor');
						foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa) {
							$valor_planejado += $ploa_administrativa->despesas()->sum('valor_total');
						}
				}
			}

			$valor_a_distribuir = $total_ploa - $valor_distribuido;

			$valor_a_planejar = $valor_distribuido - $valor_planejado;

			$programas_ploa = Programa::whereHas(
					'ploas', function ($query) use($unidade_gestora_id, $exercicio_id) {
							$query->where('exercicio_id', $exercicio_id);
							$query->whereHas('ploas_gestoras', function($query) use ($unidade_gestora_id) {
									$query->select('ploas_gestoras.valor');
									$query->where('unidade_gestora_id', $unidade_gestora_id);
							});
					}
			)->get();

            return view('ploa_gestora.index')->with([
                'programas_ploa' => $programas_ploa,
				'ploas_gestoras' => $ploas_gestoras,
                'exercicios' => Exercicio::all(),
                'programas' => Programa::all(),
                'fontes' => FonteTipo::all(),
                'acoes' => AcaoTipo::where('fav', 1)->get(),
                'instituicoes' => Instituicao::all(),
                'unidade_selecionada' => UnidadeGestora::find($unidade_gestora_id),
				'unidades_gestoras' => UnidadeGestora::getOptions(),
				'exercicio_selecionado' => $exercicio_selecionado,
				'tipo' => 'index',
				'valor_distribuido' => $valor_distribuido,
				'valor_a_distribuir' => $valor_a_distribuir,
				'valor_planejado' => $valor_planejado,
				'valor_a_planejar' => $valor_a_planejar,
				'total_ploa' => $total_ploa
            ]);
        } else {
            return view('ploa_gestora.index')->with([
							'unidades_gestoras' => UnidadeGestora::getOptions(),
							'exercicios' => Exercicio::all()						
						]);
        }
		
	}

	public function create() {
		return view('ploa_gestora.create')->with([
			'exercicios' => Exercicio::all(),
			'programas' => Programa::all(),
			'fontes' => FonteTipo::all(),
			'acoes' => AcaoTipo::where('fav', 1)->get(),
			'instituicoes' => Instituicao::all()
		]);
	}

	public function store(Request $request)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			$ploa = $this->ploaValida($request->all());
			if(!isset($ploa)) {
				session(['error_ploa_gestora' => 'Recurso n??o configurado na matriz.']);
				return redirect()->route('ploa.distribuicao', [$request->unidade_gestora_id, $request->exercicio_id]);
			}else {
				DB::beginTransaction();
				$ploa_gestora = PloaGestoraTransformer::toInstance($request->all(), $ploa);
				$rules = $this->rules($ploa_gestora, $ploa);
				if($rules['status']) {
					$ploa_gestora->save();
					DB::commit();
				} else 	{
					DB::rollBack();
					session(['error_ploa_gestora' => $rules['msg']]);
					return redirect()->route('ploa.distribuicao', [$request->unidade_gestora_id, $request->exercicio_id]);
				}
			}
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('ploa.distribuicao', [$request->unidade_gestora_id, $request->exercicio_id]);
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$ploa_gestora = PloaGestora::findOrFail($id);
		return view('ploa_gestora.edit')->with([
			'ploa_gestora' => $ploa_gestora,
			'planos_estrategicos' => PlanoEstrategico::all(),
			'eixos_estrategicos' => EixoEstrategico::where('plano_estrategico_id', $ploa_gestora->dimensao->eixo_estrategico->plano_estrategico_id)->get(),
			'dimensoes' => Dimensao::where('eixo_estrategico_id', $ploa_gestora->dimensao->eixo_estrategico_id)->get()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$ploa_gestora = PloaGestora::find($id);

		if(isset($ploa_gestora)) {
			try {
				$ploa = $this->ploaValida($request->all());
				if(!isset($ploa)) {
					session(['error_ploa_gestora' => 'Recurso n??o configurado na matriz.']);
					return redirect()->route('ploa.distribuicao', [$request->unidade_gestora_id, $request->exercicio_id]);
				}else {
					DB::beginTransaction();
					$ploa_gestora = PloaGestoraTransformer::toInstance($request->all(), $ploa, $ploa_gestora);
					$rules = $this->rules($ploa_gestora, $ploa);
					if($rules['status']) {
						$ploa_gestora->save();
						DB::commit();
					} else 	{
						DB::rollBack();
						session(['error_ploa_gestora' => $rules['msg']]);
						return redirect()->route('ploa.distribuicao', [$request->unidade_gestora_id, $request->exercicio_id]);
					}
				}
			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('ploa.distribuicao', [$request->unidade_gestora_id, $request->exercicio_id]);

	}

	public function destroy($id)
	{
		$ploa_gestora = PloaGestora::find($id);
		try {
			if(isset($ploa_gestora)) {
				$ploa_gestora->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('ploa_gestora.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'valor' => ['required'],
			'exercicio_id' => ['integer', 'required', 'exists:exercicios,id'],
			'programa_id' => ['integer', 'required', 'exists:programas,id'],
			'fonte_tipo_id' => ['integer', 'required', 'exists:fontes_tipos,id'],
			'acao_tipo_id' => ['integer', 'required', 'exists:acoes_tipos,id'],
			'instituicao_id' => ['integer', 'required', 'exists:instituicoes,id'],
			'tipo_acao' => ['required']
		]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}

	protected function rules($ploa_gestora, $ploa) {
		$existe = PloaGestora::where('ploa_id', $ploa_gestora->ploa_id)
					->where('unidade_gestora_id', $ploa_gestora->unidade_gestora_id);

		if(isset($ploa_gestora->id))
			$existe = $existe->where('id', '!=', $ploa_gestora->id);
			
		$existe = $existe->exists();

		if($existe) {
			return ['status' => false, 'msg' => 'Este v??nculo j?? existe na matriz atual.'];
		} else {
			$valor_recurso = $ploa->valor;

			$valor_utilizado = PloaGestora::where('ploa_id', $ploa_gestora->ploa_id);

			if(isset($ploa_gestora->id))
				$valor_utilizado = $valor_utilizado->where('id', '!=', $ploa_gestora->id);

			$valor_utilizado = $valor_utilizado->sum('valor');

			$valor_disponivel = $valor_recurso - $valor_utilizado;

			$valor_solicitado = $ploa_gestora->valor;

			if($valor_solicitado > $valor_disponivel)
				return ['status' => false, 'msg' => 'O valor solicitado ?? maior que o valor dispon??vel.'];
			else {
					return ['status' => true, 'msg' => ''];
				
			}
		}
	}

	protected function ploaValida($inputs) {
		$inputs = (object) $inputs;
		$recurso = Ploa::where('exercicio_id', $inputs->exercicio_id)
			->where('programa_id', $inputs->programa_id)
			->where('fonte_tipo_id', $inputs->fonte_tipo_id)
			->where('acao_tipo_id', $inputs->acao_tipo_id)
			->where('tipo_acao', $inputs->tipo_acao)
			->first();

		if(isset($recurso))
			return $recurso;
		else
			return null;
	}
}
