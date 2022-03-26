<?php

namespace App\Http\Controllers;

use App\Models\Objetivo;
use App\Models\Instituicao;
use App\Models\PlanoEstrategico;
use App\Models\EixoEstrategico;
use App\Models\Dimensao;
use App\Models\PlanoAcao;
use Illuminate\Http\Request;
use App\Http\Transformers\ObjetivoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ObjetivoController extends Controller
{
	public function opcoes($dimensao_id)
	{
		return Objetivo::select('id', 'nome as text')->where('dimensao_id', $dimensao_id)->where('ativo', 1)->get();
	}

	public function index(Request $request)
	{
		$plano_acao_id = null;

		if(isset($request->modo_exibicao)) {
			$modo_exibicao = $request->modo_exibicao;
		} else {
			$modo_exibicao = 'objetivo';
		}

		if($modo_exibicao == 'metas') {
			if(isset($request->plano_acao)) {
				$plano_acao_id = $request->plano_acao;
				$objetivos = Objetivo::whereHas(
					'metas', function ($query) use ($plano_acao_id) {
						$query->where('plano_acao_id', $plano_acao_id);
					}
				)->where('ativo', 1)->get();
			}
			else
				$objetivos = Objetivo::where('ativo', 1)->get();

		} else {
			$objetivos = Objetivo::all();
		}

		return view('objetivo.index')->with([
			'objetivos' => $objetivos,
			'modo_exibicao' => $modo_exibicao,
			'planos_acoes' => PlanoAcao::all(),
			'plano_acao_id' => $plano_acao_id
		]);
	}

	public function create() {
		return view('objetivo.create')->with([
            'planos_estrategicos' => PlanoEstrategico::all()
		]);
	}

	public function store(Request $request)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$objetivo = ObjetivoTransformer::toInstance($request->all());
			$objetivo->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('objetivo.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$objetivo = Objetivo::findOrFail($id);
		return view('objetivo.edit')->with([
			'objetivo' => $objetivo,
			'planos_estrategicos' => PlanoEstrategico::all(),
			'eixos_estrategicos' => EixoEstrategico::where('plano_estrategico_id', $objetivo->dimensao->eixo_estrategico->plano_estrategico_id)->get(),
			'dimensoes' => Dimensao::where('eixo_estrategico_id', $objetivo->dimensao->eixo_estrategico_id)->get()
		]);
	}


	public function update(Request $request, $id)
	{
		// dd($request->all());

		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$objetivo = Objetivo::find($id);

		if(isset($objetivo)) {
			try {
				DB::beginTransaction();
				$objetivo = ObjetivoTransformer::toInstance($request->all(), $objetivo);
				$objetivo->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('objetivo.index');

	}

	public function destroy($id)
	{
		$objetivo = Objetivo::find($id);
		try {
			if(isset($objetivo)) {
				$objetivo->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('objetivo.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'dimensao_id' => ['integer', 'required', 'exists:dimensoes,id']
        ]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
