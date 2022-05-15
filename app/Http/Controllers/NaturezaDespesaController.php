<?php

namespace App\Http\Controllers;

use App\Models\NaturezaDespesa;
use App\Models\GrupoFonte;
use App\Models\Especificacao;
use Illuminate\Http\Request;
use App\Http\Transformers\NaturezaDespesaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NaturezaDespesaController extends Controller
{
	public function getOptions($id, $acao_id, $tipo, $ploa_id) {
		$options = [];

		switch($tipo) {
			case 'unidade_administrativa':
				$naturezas_despesas = NaturezaDespesa::whereHas('despesas', function($query) use($id, $ploa_id, $acao_id){
					$query->whereHas('ploa_administrativa', function($query) use($id, $ploa_id, $acao_id) {
						$query->where('unidade_administrativa_id', $id);
						$query->whereHas('ploa_gestora', function($query) use($id, $ploa_id, $acao_id) {
							$query->whereHas('ploa', function($query) use($id, $ploa_id, $acao_id) {
								$query->where('exercicio_id', $ploa_id);
								$query->where('acao_tipo_id', $acao_id);
							});
						});
					});
				})
				->get();

				foreach($naturezas_despesas as $natureza_despesa) {
					$options['id'] = $natureza_despesa->id;
					$options['text'] = $natureza_despesa->nome_completo;
				}
				break;
		}

		return [$options];
	}

	public function favoritar($id)
	{
		$natureza_despesa = NaturezaDespesa::findOrFail($id);

		$natureza_despesa->fav = !$natureza_despesa->fav;
		$natureza_despesa->save();

		return redirect()->route('natureza_despesa.index');
	}

	public function index()
	{
		return view('natureza_despesa.index')->with([
			'naturezas_despesas' => NaturezaDespesa::orderBy('fav', 'desc')->orderBy('nome')->get()
		]);
	}

	public function create() {
		return view('natureza_despesa.create');
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$natureza_despesa = NaturezaDespesaTransformer::toInstance($request->all());
			$natureza_despesa->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('natureza_despesa.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$natureza_despesa = NaturezaDespesa::findOrFail($id);
		return view('natureza_despesa.edit')->with([
			'natureza_despesa' => $natureza_despesa
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		$natureza_despesa = NaturezaDespesa::find($id);

		if(isset($natureza_despesa)) {
			try {
				DB::beginTransaction();
				$natureza_despesa = NaturezaDespesaTransformer::toInstance($request->all(), $natureza_despesa);
				$natureza_despesa->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('natureza_despesa.index');

	}

	public function destroy($id)
	{
		$natureza_despesa = NaturezaDespesa::find($id);
		try {
			if(isset($natureza_despesa)) {
				$natureza_despesa->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('natureza_despesa.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'codigo' => ['required'],
			'nome' => ['required'],
			'tipo' => ['required']
		]);

		if ($validator->fails()) {
			return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
		}
	}
}
