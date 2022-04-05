<?php

namespace App\Http\Controllers;

use App\Models\DespesaModelo;
use App\Models\NaturezaDespesa;
use App\Models\PlanoAcao;
use App\Models\CentroCusto;
use Illuminate\Http\Request;
use App\Http\Transformers\DespesaModeloTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DespesaModeloController extends Controller
{
	public function index(Request $request)
	{
        $despesas_modelos = DespesaModelo::all();

		return view('despesa_modelo.index')->with([
            'despesas_modelos' => $despesas_modelos,
        ]);
	}
		

	public function create(Request $request) {
		return view('despesa_modelo.create')->with([
			'planos_acoes' => PlanoAcao::all(),
			'naturezas_despesas' => NaturezaDespesa::where('fav', 1)->get(),
			'centros_custos' => CentroCusto::all()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);


		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$despesa_modelo = DespesaModeloTransformer::toInstance($request->all());
			$despesa_modelo->save();

			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('despesa_modelo.index', ['objetivo' => $despesa_modelo->objetivo_id]);
	}

	public function show($id)
	{
	}

	public function edit($id, Request $request) {
		$despesa_modelo = DespesaModelo::findOrFail($id);
		if($request->objetivo) {
			$objetivo_id = $request->objetivo;
			$objetivo = Objetivo::find($objetivo_id);
			$plano_estrategico_id = $objetivo->dimensao->eixo_estrategico->plano_estrategico_id;
			$plano_estrategico = $objetivo->dimensao->eixo_estrategico->plano_estrategico->nome;
			$eixo_estrategico = $objetivo->dimensao->eixo_estrategico->nome;
			$dimensao = $objetivo->dimensao->nome;
			$planos_acoes = PlanoAcao::where('plano_estrategico_id', $plano_estrategico_id)->get();

			return view('despesa_modelo.edit')->with([
				'despesa_modelo' => $despesa_modelo,
				'unidades_gestoras' => UnidadeGestora::all(),
				'objetivo' => $objetivo,
				'plano_estrategico' => $plano_estrategico,
				'eixo_estrategico' => $eixo_estrategico,
				'dimensao' => $dimensao,
				'planos_acoes' => $planos_acoes
			]);
		}
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$despesa_modelo = DespesaModelo::find($id);


		if(isset($despesa_modelo)) {
			try {
				DB::beginTransaction();
				$despesa_modelo = DespesaModeloTransformer::toInstance($request->all(), $despesa_modelo);
				$despesa_modelo->save();
				if(isset($despesa_modelo)) {
					if(isset($request->unidade_gestora_id)) {
						if(count($request->unidade_gestora_id) > 0) {
							$despesa_modelo->responsaveis()->sync($request->unidade_gestora_id);
						}
					} else {
						$despesa_modelo->responsaveis()->detach();
					}
				}
	
				DB::commit();
			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('despesa_modelo.index', ['objetivo' => $despesa_modelo->objetivo_id]);
	}

	public function destroy($id)
	{
		$despesa_modelo = DespesaModelo::find($id);
		try {
			if(isset($despesa_modelo)) {
				$despesa_modelo->responsaveis()->detach();
				$despesa_modelo->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('despesa_modelo.index', ['objetivo' => $despesa_modelo->objetivo_id]);
	}

	protected function validation($request) 
	{
		// dd($request->all());
		$validator = Validator::make($request->all(), [
			// 'nome' => ['required'],
			// 'descricao' => ['nullable'],
			// 'tipo' => ['required'],
			// 'tipo_dado' => ['required'],
			// 'valor_inicial' => ['required'],
			// 'valor_final' => ['required'],
			// 'valor_atingido' => ['nullable'],
			// 'objetivo_id' => ['required', 'exists:objetivos,id'],
			// 'unidade_gestora_id.*' => ['required', 'exists:unidades_gestoras,id']
		]);

		if ($validator->fails()) {
			return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
		}
	}
}
