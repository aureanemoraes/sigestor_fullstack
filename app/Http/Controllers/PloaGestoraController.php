<?php

namespace App\Http\Controllers;

use App\Models\PloaGestora;
use App\Models\Exercicio;
use App\Models\Programa;
use App\Models\FonteTipo;
use App\Models\AcaoTipo;
use App\Models\Instituicao;
use App\Models\UnidadeGestora;
use App\Models\Ploa;
use Illuminate\Http\Request;
use App\Http\Transformers\PloaGestoraTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PloaGestoraController extends Controller
{
	public function distribuicao() {
		$total_ploa = PloaGestora::sum('valor');

		return view('ploa_gestora.distribuicao')->with([
			'programas' => Programa::all(),
			'total_ploa' => $total_ploa
		]);
	}

	public function opcoes($dimensao_id)
	{
		return PloaGestora::select('id', 'nome as text')->where('dimensao_id', $dimensao_id)->where('ativo', 1)->get();
	}

	public function index($unidade_gestora_id = null, $exercicio_id = null)
	{
        if(isset($unidade_gestora_id) && isset($exercicio_id)) {
						$exercicio_selecionado = Exercicio::find($exercicio_id);

            $ploas_gestoras = PloaGestora::whereHas(
							'ploa', function ($query) use ($exercicio_id) {
								$query->where('exercicio_id', $exercicio_id);
							}
						)->where('unidade_gestora_id', $unidade_gestora_id)->get();

						$total_ploa = $ploas_gestoras->sum('valor');

						$programas_ploa = Programa::whereHas(
								'ploas', function ($query) use($unidade_gestora_id, $exercicio_id) {
										$query->where('exercicio_id', $exercicio_id);
										$query->whereHas('ploas_gestoras', function($query) use ($unidade_gestora_id) {
												$query->select('ploas_gestoras.valor');
												$query->where('unidade_gestora_id', $unidade_gestora_id);
										});
								}
						)->get();

						foreach($programas_ploa as $programa) {
							if(count($programa->ploas) > 0) {
								$programa->valor_total = 0;
								foreach($programa->ploas as $ploa) {
									$programa->valor_total += $ploa->ploas_gestoras()->sum('ploas_gestoras.valor');
								}
							}
						}

            return view('ploa_gestora.index')->with([
                'programas_ploa' => $programas_ploa,
								'ploas_gestoras' => $ploas_gestoras,
                'exercicios' => Exercicio::all(),
                'programas' => Programa::all(),
                'fontes' => FonteTipo::all(),
                'acoes' => AcaoTipo::where('fav', 1)->get(),
                'instituicoes' => Instituicao::all(),
                'total_ploa' => $total_ploa,
                'unidade_selecionada' => UnidadeGestora::find($unidade_gestora_id),
								'unidades_gestoras' => UnidadeGestora::all(),
								'exercicio_selecionado' => $exercicio_selecionado
            ]);
        } else {
            return view('ploa_gestora.index')->with([
							'unidades_gestoras' => UnidadeGestora::all(),
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
				session(['error_ploa_gestora' => 'Recurso não configurado na matriz.']);
				return redirect()->route('ploa_gestora.index', [$request->unidade_gestora_id, $request->exercicio_id]);
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
					return redirect()->route('ploa_gestora.index', [$request->unidade_gestora_id, $request->exercicio_id]);
				}
			}
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('ploa_gestora.index', [$request->unidade_gestora_id, $request->exercicio_id]);
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
					session(['error_ploa_gestora' => 'Recurso não configurado na matriz.']);
					return redirect()->route('ploa_gestora.index', [$request->unidade_gestora_id, $request->exercicio_id]);
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
						return redirect()->route('ploa_gestora.index', [$request->unidade_gestora_id, $request->exercicio_id]);
					}
				}
			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('ploa_gestora.index', [$request->unidade_gestora_id, $request->exercicio_id]);

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
			return ['status' => false, 'msg' => 'Este vínculo já existe na matriz atual.'];
		} else {
			$valor_recurso = $ploa->valor;

			$valor_utilizado = PloaGestora::where('ploa_id', $ploa_gestora->ploa_id)->sum('valor');

			$valor_disponivel = $valor_recurso - $valor_utilizado;

			$valor_solicitado = $ploa_gestora->valor;

			if($valor_solicitado > $valor_disponivel)
				return ['status' => false, 'msg' => 'O valor solicitado é maior que o valor disponível.'];
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
