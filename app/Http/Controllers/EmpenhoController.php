<?php

namespace App\Http\Controllers;

use App\Models\Empenho;
use App\Models\Instituicao;
use App\Models\Exercicio;
use App\Models\UnidadeGestora;
use App\Models\CertidaoCredito;
use Illuminate\Http\Request;
use App\Http\Transformers\EmpenhoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmpenhoController extends Controller
{
	public function index(Request $request)
	{
		if(isset($request->ploa) && isset($request->unidade_gestora)) {
			$exercicio = Exercicio::find($request->ploa);
			$unidade_gestora_id= $request->unidade_gestora;
			$unidade_selecionada = UnidadeGestora::find($request->unidade_gestora);
			$unidades_gestoras = UnidadeGestora::all();
			$certidoes_credito = CertidaoCredito::whereHas(
				'credito_planejado', function ($query) use($unidade_gestora_id) {
					$query->whereHas('despesa', function ($query) use($unidade_gestora_id) {
						$query->whereHas('ploa_administrativa', function ($query) use($unidade_gestora_id){
							$query->whereHas('ploa_gestora', function ($query) use($unidade_gestora_id){
								$query->where('unidade_gestora_id', $unidade_gestora_id);
							});
						});
					});
				}
			)->get();

			return view('empenho.index')->with([
				'certidoes_creditos' => $certidoes_credito,
				'exercicio' => $exercicio,
				'unidades_gestoras' => $unidades_gestoras,
				'unidade_selecionada' => $unidade_selecionada
			]);
		}
	}

	public function create(Request $request) {
		if(isset($request->certidao_credito)) {
			$certidao_credito = CertidaoCredito::find($request->certidao_credito);

			return view('empenho.create')->with([
				'certidao_credito' => $certidao_credito
			]);
		}
		
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$empenho = EmpenhoTransformer::toInstance($request->all());

			$empenho->save();
			DB::commit();

			return redirect()->route('empenho.index', ['ploa' => $empenho->exercicio_id, 'unidade_gestora' => $empenho->unidade_gestora_id]);

		} catch (Exception $ex) {
			DB::rollBack();
			return redirect()->back();
		}
	}

	public function show($id, Request $request)
	{
	
		$empenho = Empenho::find($id);
		if(isset($empenho))
			return view('empenho.show')->with([
				'empenho' => $empenho
			]);
	}

	public function edit($id) {
		$empenho = Empenho::findOrFail($id);
		return view('empenho.edit')->with([
			'empenho' => $empenho,
			'instituicoes' => Instituicao::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$empenho = Empenho::find($id);

		if(isset($empenho)) {
			try {
				DB::beginTransaction();
				$empenho = EmpenhoTransformer::toInstance($request->all(), $empenho);
				$empenho->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('empenho.index');

	}

	public function destroy($id)
	{
		$empenho = Empenho::find($id);
		try {
			if(isset($empenho)) {
				$empenho->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('empenho.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
        
        ]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
