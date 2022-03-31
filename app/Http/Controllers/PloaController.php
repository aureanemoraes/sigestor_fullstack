<?php

namespace App\Http\Controllers;

use App\Models\Ploa;
use App\Models\Exercicio;
use App\Models\Programa;
use App\Models\FonteTipo;
use App\Models\AcaoTipo;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Http\Transformers\PloaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PloaController extends Controller
{
	public function distribuicao($exercicio_id = null) {
		$valor_distribuido = 0;
		$valor_a_distribuir = 0;
		$total_ploa = 0;

		if(!isset($exercicio_id)) {
			$exercicio_selecionado = Exercicio::all()->last();
			$exercicio_id = $exercicio_selecionado->id;
		}
		else 
			$exercicio_selecionado = Exercicio::find($exercicio_id);

		$ploas = Ploa::where('exercicio_id', $exercicio_id)->get();

		if(count($ploas) > 0) {
			foreach($ploas as $ploa) {
				$valor_distribuido += $ploa->ploas_gestoras()->sum('ploas_gestoras.valor');
			}
		}

		$total_ploa = $ploas->sum('valor');

		$valor_a_distribuir = $total_ploa - $valor_distribuido;

		$programas_ploa = Programa::whereHas(
			'ploas', function ($query) use($exercicio_id) {
				$query->where('exercicio_id', $exercicio_id);
			}
		)->get();

		return view('ploa.distribuicao')->with([
			'programas_ploa' => $programas_ploa,
			'exercicios' => Exercicio::all(),
			'exercicio_selecionado' => $exercicio_selecionado,
			'valor_distribuido' => $valor_distribuido,
			'valor_a_distribuir' => $valor_a_distribuir,
			'total_ploa' => $total_ploa
		]);
	}

	public function opcoes($dimensao_id)
	{
		return Ploa::select('id', 'nome as text')->where('dimensao_id', $dimensao_id)->where('ativo', 1)->get();
	}

	public function index($exercicio_id = null)
	{
		if(!isset($exercicio_id)) {
			$exercicio_selecionado = Exercicio::all()->last();
			$exercicio_id = $exercicio_selecionado->id;
		}
		else 
			$exercicio_selecionado = Exercicio::find($exercicio_id);
		

		$total_ploa = Ploa::where('exercicio_id', $exercicio_id)->sum('valor');

		return view('ploa.index')->with([
			'programas_ploa' => Programa::whereHas(
				'ploas', function ($query) use($exercicio_id) {
					$query->where('exercicio_id', $exercicio_id);
				}
			)->get(),
			'exercicios' => Exercicio::all(),
			'programas' => Programa::all(),
			'fontes' => FonteTipo::all(),
			'acoes' => AcaoTipo::where('fav', 1)->get(),
			'instituicoes' => Instituicao::all(),
			'total_ploa' => $total_ploa,
			'exercicio_selecionado' => $exercicio_selecionado
		]);
	}

	public function create() {
		return view('ploa.create')->with([
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
			DB::beginTransaction();
			$ploa = PloaTransformer::toInstance($request->all());
			$rules = $this->rules($ploa);
			if($rules['status']) {
				$ploa->save();
				DB::commit();
			} else 	{
				DB::rollBack();
				session(['error_ploa' => $rules['msg']]);
				return redirect()->route('ploa.index', $request->exercicio_id);
			}

		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('ploa.index', $request->exercicio_id);
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$ploa = Ploa::findOrFail($id);
		return view('ploa.edit')->with([
			'ploa' => $ploa,
			'planos_estrategicos' => PlanoEstrategico::all(),
			'eixos_estrategicos' => EixoEstrategico::where('plano_estrategico_id', $ploa->dimensao->eixo_estrategico->plano_estrategico_id)->get(),
			'dimensoes' => Dimensao::where('eixo_estrategico_id', $ploa->dimensao->eixo_estrategico_id)->get()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$ploa = Ploa::find($id);

		if(isset($ploa)) {
			try {
				DB::beginTransaction();
				$ploa = PloaTransformer::toInstance($request->all(), $ploa);
				$rules = $this->rules($ploa);
				if($rules['status']) {
					$ploa->save();
					DB::commit();
				} else 	{
					DB::rollBack();
					session(['error_ploa' => $rules['msg']]);
					return redirect()->route('ploa.index', $request->exercicio_id);
				}
	
			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('ploa.index', $request->exercicio_id);

	}

	public function destroy($id)
	{
		$ploa = Ploa::find($id);
		$exercicio_id = $ploa->exercicio_id;
		try {
			if(isset($ploa)) {
				$ploa->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('ploa.index', $exercicio_id);

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

	protected function rules($ploa) {
		$existe = Ploa::where('exercicio_id', $ploa->exercicio_id)
			->where('programa_id', $ploa->programa_id)
			->where('fonte_tipo_id', $ploa->fonte_tipo_id)
			->where('acao_tipo_id', $ploa->acao_tipo_id)
			->where('tipo_acao', $ploa->tipo_acao);

		if(isset($ploa->id))
			$existe = $existe->where('id', '!=', $ploa->id);
			
		$existe = $existe->exists();

		if($existe) {
			return ['status' => false, 'msg' => 'Este vínculo já existe na matriz atual.'];
		} else 
			return ['status' => true, 'msg' => ''];
	}
}
