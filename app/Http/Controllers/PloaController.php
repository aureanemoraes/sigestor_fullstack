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

class PloaController extends Controller
{
	public function opcoes($dimensao_id)
	{
		return Ploa::select('id', 'nome as text')->where('dimensao_id', $dimensao_id)->where('ativo', 1)->get();
	}

	public function index()
	{
		return view('ploa.index')->with([
			'ploas' => Ploa::all()
		]);
	}

	public function create() {
		return view('ploa.create')->with([
			'exercicios' => Exercicio::all(),
			'programas' => Programa::all(),
			'fontes' => FonteTipo::all(),
			'acoes' => AcaoTipo::where('fav', 1)->get(),
			'instituicoes' => Instituicao::all(),
		]);
	}

	public function store(Request $request)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$ploa = PloaTransformer::toInstance($request->all());
			$ploa->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('ploa.index');
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
		// dd($request->all());

		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$ploa = Ploa::find($id);

		if(isset($ploa)) {
			try {
				DB::beginTransaction();
				$ploa = PloaTransformer::toInstance($request->all(), $ploa);
				$ploa->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('ploa.index');

	}

	public function destroy($id)
	{
		$ploa = Ploa::find($id);
		try {
			if(isset($ploa)) {
				$ploa->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('ploa.index');

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
}
