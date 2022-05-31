<?php

namespace App\Http\Controllers;

use App\Models\MetaOrcamentaria;
use App\Models\GrupoFonte;
use App\Models\Especificacao;
use App\Models\NaturezaDespesa;
use App\Models\AcaoTipo;
use Illuminate\Http\Request;
use App\Http\Transformers\MetaOrcamentariaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MetaOrcamentariaController extends Controller
{
	// public function getOptions($id, $acao_id, $tipo, $ploa_id) {
	// 	$options = [];

	// 	switch($tipo) {
	// 		case 'unidade_administrativa':
	// 			$metas_orcamentarias = MetaOrcamentaria::whereHas('despesas', function($query) use($id, $ploa_id, $acao_id){
	// 				$query->whereHas('ploa_administrativa', function($query) use($id, $ploa_id, $acao_id) {
	// 					$query->where('unidade_administrativa_id', $id);
	// 					$query->whereHas('ploa_gestora', function($query) use($id, $ploa_id, $acao_id) {
	// 						$query->whereHas('ploa', function($query) use($id, $ploa_id, $acao_id) {
	// 							$query->where('exercicio_id', $ploa_id);
	// 							$query->where('acao_tipo_id', $acao_id);
	// 						});
	// 					});
	// 				});
	// 			})
	// 			->get();

	// 			foreach($metas_orcamentarias as $meta_orcamentaria) {
	// 				$options['id'] = $meta_orcamentaria->id;
	// 				$options['text'] = $meta_orcamentaria->nome_completo;
	// 			}
	// 			break;
	// 	}

	// 	return [$options];
	// }

	// public function favoritar($id)
	// {
	// 	$meta_orcamentaria = MetaOrcamentaria::findOrFail($id);

	// 	$meta_orcamentaria->fav = !$meta_orcamentaria->fav;
	// 	$meta_orcamentaria->save();

	// 	return redirect()->route('meta_orcamentaria.index');
	// }

	public function index()
	{
		return view('meta_orcamentaria.index')->with([
			'metas_orcamentarias' => MetaOrcamentaria::all()
		]);
	}

	public function create() {
		return view('meta_orcamentaria.create')->with([
			'naturezas_despesas' => NaturezaDespesa::where('fav', 1)->get(),
			'acoes' => AcaoTipo::where('fav', 1)->get()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$meta_orcamentaria = MetaOrcamentariaTransformer::toInstance($request->all());
			$meta_orcamentaria->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('meta_orcamentaria.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$meta_orcamentaria = MetaOrcamentaria::findOrFail($id);
		return view('meta_orcamentaria.edit')->with([
			'meta_orcamentaria' => $meta_orcamentaria
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		$meta_orcamentaria = MetaOrcamentaria::find($id);

		if(isset($meta_orcamentaria)) {
			try {
				DB::beginTransaction();
				$meta_orcamentaria = MetaOrcamentariaTransformer::toInstance($request->all(), $meta_orcamentaria);
				$meta_orcamentaria->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('meta_orcamentaria.index');

	}

	public function destroy($id)
	{
		$meta_orcamentaria = MetaOrcamentaria::find($id);
		try {
			if(isset($meta_orcamentaria)) {
				$meta_orcamentaria->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('meta_orcamentaria.index');

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
