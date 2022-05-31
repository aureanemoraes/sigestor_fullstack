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

		// dd($request->all());
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
		$options[] = ['id' => 'valor', 'text' => 'Valor unitário'];
		$options[] = ['id' => 'valor_total', 'text' => 'Valor total'];

		if(isset($meta_orcamentaria) && isset($meta_orcamentaria->natureza_despesa_id)) {
		  if(isset($meta_orcamentaria->natureza_despesa->fields) && count($meta_orcamentaria->natureza_despesa->fields) > 0) {
			  foreach($meta_orcamentaria->natureza_despesa->fields as $field) {
				$options[] = ['id' => $field['slug'], 'text' => $field['label']];
			  }
		  }
		} 
		
		return view('meta_orcamentaria.edit')->with([
			'meta_orcamentaria' => $meta_orcamentaria,
			'naturezas_despesas' => NaturezaDespesa::where('fav', 1)->get(),
			'acoes' => AcaoTipo::where('fav', 1)->get(),
			'options' => $options
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
			'nome' => ['required'],
			'qtd_estimada' => ['nullable'],
			'qtd_alcancada' => ['nullable'],
			'field' => ['nullable'],
			'natureza_despesa_id' => ['nullable', 'exists:naturezas_despesas,id'],
			'acao_tipo_id' => ['nullable', 'exists:acoes_tipos,id'],
		]);

		if ($validator->fails()) {
			return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
		}
	}
}
