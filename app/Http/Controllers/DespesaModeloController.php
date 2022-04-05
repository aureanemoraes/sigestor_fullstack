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

		return redirect()->route('despesa_modelo.index');
	}

	public function show($id)
	{
	}

	public function edit($id, Request $request) {
		$despesa_modelo = DespesaModelo::findOrFail($id);
		if(isset($despesa_modelo->subnatureza_despesa_id))
			$subnaturezas_despesas = Subnatureza::where('natureza_despesa_id', $despesa_modelo->natureza_despesa_id)->get();
		else
			$subnaturezas_despesas = null;
			
		return view('despesa_modelo.edit')->with([
			'despesa_modelo' => $despesa_modelo,
			'planos_acoes' => PlanoAcao::all(),
			'naturezas_despesas' => NaturezaDespesa::where('fav', 1)->get(),
			'subnaturezas_despesas' => $subnaturezas_despesas,
			'centros_custos' => CentroCusto::all()
		]);
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
	
				DB::commit();
			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('despesa_modelo.index');
	}

	public function destroy($id)
	{
		$despesa_modelo = DespesaModelo::find($id);
		try {
			if(isset($despesa_modelo)) {
				$despesa_modelo->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('despesa_modelo.index');
	}

	protected function validation($request) 
	{
		// dd($request->all());
		$validator = Validator::make($request->all(), [
			'descricao' => ['required'],
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
