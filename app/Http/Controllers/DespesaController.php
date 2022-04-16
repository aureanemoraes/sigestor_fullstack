<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\NaturezaDespesa;
use App\Models\PlanoAcao;
use App\Models\CentroCusto;
use App\Models\PloaAdministrativa;
use App\Models\DespesaModelo;
use App\Models\Meta;
use Illuminate\Http\Request;
use App\Http\Transformers\DespesaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DespesaController extends Controller
{
	public function index(Request $request)
	{
		$ploa_administrativa = isset($request->ploa_administrativa) ? PloaAdministrativa::find($request->ploa_administrativa) : null;
		if (isset($ploa_administrativa)) {
			$despesas = Despesa::where('ploa_administrativa_id', $ploa_administrativa->id)->get();

			return view('despesa.index')->with([
				'despesas' => $despesas,
				'ploa_administrativa' => $ploa_administrativa
			]);
		}
	}
		

	public function create(Request $request) {
        if(isset($request->ploa_administrativa)) {
            $ploa_administrativa_id = $request->ploa_administrativa;
            $ploa_administrativa = PloaAdministrativa::find($ploa_administrativa_id); 
            $despesas_modelos = DespesaModelo::all();

            return view('despesa.create')->with([
                'despesas_modelos' => $despesas_modelos,
                'ploa_administrativa' => $ploa_administrativa,
                'planos_acoes' => PlanoAcao::all(),
                'naturezas_despesas' => NaturezaDespesa::where('fav', 1)->get(),
                'centros_custos' => CentroCusto::all(),
                'ploa_administrativa_id' => $ploa_administrativa_id
            ]);
        }
		
	}

	public function store(Request $request)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$despesa = DespesaTransformer::toInstance($request->all());
			$despesa->save();

			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('despesa.index');
	}

	public function show($id)
	{
	}

	public function edit($id, Request $request) {
		$despesa = Despesa::findOrFail($id);
		$ploa_administrativa = PloaAdministrativa::find($despesa->ploa_administrativa_id);
		$despesas_modelos = DespesaModelo::all();

		if(isset($despesa->subnatureza_despesa_id))
			$subnaturezas_despesas = Subnatureza::where('natureza_despesa_id', $despesa->natureza_despesa_id)->get();
		else
			$subnaturezas_despesas = null;
			
		return view('despesa.edit')->with([
			'despesa' => $despesa,
			'despesas_modelos' => $despesas_modelos,
			'ploa_administrativa' => $ploa_administrativa,
			'planos_acoes' => PlanoAcao::all(),
			'naturezas_despesas' => NaturezaDespesa::where('fav', 1)->get(),
			'subnaturezas_despesas' => $subnaturezas_despesas,
			'centros_custos' => CentroCusto::all(),
			'metas' => Meta::where('plano_acao_id', $despesa->meta->plano_acao_id)->get()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$despesa = Despesa::find($id);

		if(isset($despesa)) {
			try {
				DB::beginTransaction();
				$despesa = DespesaTransformer::toInstance($request->all(), $despesa);
				$despesa->save();
	
				DB::commit();
			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('despesa.index');
	}

	public function destroy($id)
	{
		$despesa = Despesa::find($id);
		try {
			if(isset($despesa)) {
				$despesa->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('despesa.index');
	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'descricao' => ['required'],
			'valor' => ['required'],
			'tipo' => ['required'],
			'ploa_administrativa_id' => ['required', 'exists:ploas_administrativas,id'],
			'centro_custo_id' => ['required', 'exists:centros_custos,id'],
            'natureza_despesa_id' => ['required', 'exists:naturezas_despesas,id'],
            'subnatureza_despesa_id' => ['nullable', 'exists:subnaturezas_despesas,id'],
            'meta_id' => ['required', 'exists:metas,id'],
            'despesa_modelo_id' => ['nullable', 'exists:despesas_modelos,id'],
		]);

		if ($validator->fails()) {
			return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
		}
	}
}
