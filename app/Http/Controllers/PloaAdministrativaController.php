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
use App\Http\Transformers\PloaAdministrativaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PloaAdministrativaController extends Controller
{
	public function opcoes($dimensao_id)
	{
		return PloaAdministrativa::select('id', 'nome as text')->where('dimensao_id', $dimensao_id)->where('ativo', 1)->get();
	}

	public function index($unidade_administrativa_id = null, $exercicio_id = null)
	{
		$valor_planejado = 0;
		$valor_a_planejar = 0;
		$total_ploa = 0;

        if(isset($unidade_administrativa_id) && isset($exercicio_id)) {
			$exercicio_selecionado = Exercicio::find($exercicio_id);

            $ploas_administrativas = PloaAdministrativa::whereHas(
				'ploa_gestora', function ($query) use ($exercicio_id){
					$query->whereHas(
						'ploa', function ($query) use ($exercicio_id) {
							$query->where('exercicio_id', $exercicio_id);
						}
					);
				}
			)->where('unidade_administrativa_id', $unidade_administrativa_id)->get();

			$total_ploa = $ploas_administrativas->sum('valor');

			foreach($ploas_administrativas as $ploa_administrativa) {
				if(count($ploa_administrativa->despesas) > 0) {
					$valor_planejado += $ploa_administrativa->despesas()->sum('valor_total');
				} 
			}

			$valor_a_planejar = $total_ploa - $valor_planejado;

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

			// foreach($programas_ploa as $programa) {
			// 	if(count($programa->ploas) > 0) {
			// 		$programa->valor_total = 0;
			// 		foreach($programa->ploas as $ploa) {
			// 			if(count($ploa->ploas_gestoras) > 0) {
			// 				$programa->valor_total += $ploa->ploas_gestoras()->sum('valor');
			// 			}
			// 		}
			// 	}
			// }

            return view('ploa_administrativa.index')->with([
                'programas_ploa' => $programas_ploa,
				'ploas_administrativas' => $ploas_administrativas,
                'exercicios' => Exercicio::all(),
                'programas' => Programa::all(),
                'fontes' => FonteTipo::all(),
                'acoes' => AcaoTipo::where('fav', 1)->get(),
                'instituicoes' => Instituicao::all(),
                'unidade_selecionada' => UnidadeAdministrativa::find($unidade_administrativa_id),
				'unidades_administrativas' => UnidadeAdministrativa::all(),
				'exercicio_selecionado' => $exercicio_selecionado,
				'tipo' => 'index',
				'valor_planejado' => $valor_planejado,
				'valor_a_planejar' => $valor_a_planejar,
				'total_ploa' => $total_ploa
            ]);
        } else {
            return view('ploa_administrativa.index')->with([
							'unidades_administrativas' => UnidadeAdministrativa::all(),
							'exercicios' => Exercicio::all()						
						]);
        }
		
	}

	public function create() {
		return view('ploa_administrativa.create')->with([
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
			$ploa_gestora = $this->ploaValida($request->all());
			if(!isset($ploa_gestora)) {
				session(['error_ploa_administrativa' => 'Recurso não configurado na matriz.']);
				return redirect()->route('ploa_gestora.distribuicao', [$request->unidade_administrativa_id, $request->exercicio_id]);
			}else {
				DB::beginTransaction();
				$ploa_administrativa = PloaAdministrativaTransformer::toInstance($request->all(), $ploa_gestora);
				$rules = $this->rules($ploa_administrativa, $ploa_gestora);
				if($rules['status']) {
					$ploa_administrativa->save();
					DB::commit();
				} else 	{
					DB::rollBack();
					session(['error_ploa_administrativa' => $rules['msg']]);
					return redirect()->route('ploa_gestora.distribuicao', [$request->unidade_administrativa_id, $request->exercicio_id]);
				}
			}
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('ploa_gestora.distribuicao', [$request->unidade_administrativa_id, $request->exercicio_id]);
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$ploa_administrativa = PloaAdministrativa::findOrFail($id);
		return view('ploa_administrativa.edit')->with([
			'ploa_gestora' => $ploa_administrativa,
			'planos_estrategicos' => PlanoEstrategico::all(),
			'eixos_estrategicos' => EixoEstrategico::where('plano_estrategico_id', $ploa_administrativa->dimensao->eixo_estrategico->plano_estrategico_id)->get(),
			'dimensoes' => Dimensao::where('eixo_estrategico_id', $ploa_administrativa->dimensao->eixo_estrategico_id)->get()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$ploa_administrativa = PloaAdministrativa::find($id);

		if(isset($ploa_administrativa)) {
			try {
				$ploa_gestora = $this->ploaValida($request->all());
				if(!isset($ploa_gestora)) {
					session(['error_ploa_administrativa' => 'Recurso não configurado na matriz.']);
					return redirect()->route('ploa_gestora.distribuicao', [$request->unidade_administrativa_id, $request->exercicio_id]);
				}else {
					DB::beginTransaction();
					$ploa_administrativa = PloaAdministrativaTransformer::toInstance($request->all(), $ploa_gestora, $ploa_administrativa);
					$rules = $this->rules($ploa_administrativa, $ploa_gestora);
					if($rules['status']) {
						$ploa_administrativa->save();
						DB::commit();
					} else 	{
						DB::rollBack();
						session(['error_ploa_administrativa' => $rules['msg']]);
						return redirect()->route('ploa_gestora.distribuicao', [$request->unidade_administrativa_id, $request->exercicio_id]);
					}
				}
			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('ploa_gestora.distribuicao', [$request->unidade_administrativa_id, $request->exercicio_id]);

	}

	public function destroy($id)
	{
		$ploa_administrativa = PloaAdministrativa::find($id);
		try {
			if(isset($ploa_administrativa)) {
				$ploa_administrativa->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('ploa_administrativa.index');

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

	protected function rules($ploa_administrativa, $ploa_gestora) {

		$existe = PloaAdministrativa::where('ploa_gestora_id', $ploa_administrativa->ploa_gestora_id)
					->where('unidade_administrativa_id', $ploa_administrativa->unidade_administrativa_id);

		if(isset($ploa_administrativa->id))
			$existe = $existe->where('id', '!=', $ploa_administrativa->id);
			
		$existe = $existe->exists();

		if($existe) {
			return ['status' => false, 'msg' => 'Este vínculo já existe na matriz atual.'];
		} else {
			$valor_recurso = $ploa_gestora->valor;

			$valor_utilizado = PloaAdministrativa::where('ploa_gestora_id', $ploa_administrativa->ploa_gestora_id);
			
			if(isset($ploa_administrativa->id))
				$valor_utilizado = $valor_utilizado->where('id', '!=', $ploa_administrativa->id);

			$valor_utilizado = $valor_utilizado->sum('valor');

			$valor_disponivel = $valor_recurso - $valor_utilizado;

			$valor_solicitado = $ploa_administrativa->valor;

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

		if(isset($recurso)) {
			$recurso_gestora = PloaGestora::where('ploa_id', $recurso->id)->first();

			if(isset($recurso_gestora))
				return $recurso_gestora;
			else
				return null;
		}
		else
			return null;
	}
}
