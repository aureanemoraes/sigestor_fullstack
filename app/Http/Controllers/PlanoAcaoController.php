<?php

namespace App\Http\Controllers;

use App\Models\PlanoAcao;
use App\Models\Instituicao;
use App\Models\PlanoEstrategico;
use Illuminate\Http\Request;
use App\Http\Transformers\PlanoAcaoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlanoAcaoController extends Controller
{
	public function index()
	{
		return view('plano_acao.index')->with([
			'planos_acoes' => PlanoAcao::get()
		]);
	}

	public function create() {
		return view('plano_acao.create')->with([
			'instituicoes' => Instituicao::all(),
            'planos_estrategicos' => PlanoEstrategico::all()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$plano_acao = PlanoAcaoTransformer::toInstance($request->all());
			$plano_acao->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('plano_acao.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$plano_acao = PlanoAcao::findOrFail($id);
		return view('plano_acao.edit')->with([
			'plano_acao' => $plano_acao,
			'instituicoes' => Instituicao::all(),
            'planos_estrategicos' => PlanoEstrategico::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$plano_acao = PlanoAcao::find($id);

		if(isset($plano_acao)) {
			try {
				DB::beginTransaction();
				$plano_acao = PlanoAcaoTransformer::toInstance($request->all(), $plano_acao);
				$plano_acao->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('plano_acao.index');

	}

	public function destroy($id)
	{
		$plano_acao = PlanoAcao::find($id);
		try {
			if(isset($plano_acao)) {
				$plano_acao->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('plano_acao.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'data_inicio' => ['required'],
            'data_fim' => ['required'],
            'instituicao_id' => ['integer', 'required', 'exists:instituicoes,id'],
            'plano_estrategico_id' => ['integer', 'required', 'exists:planos_estrategicos,id']
        ]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
