<?php

namespace App\Http\Controllers;

use App\Models\AcaoTipo;
use App\Models\GrupoFonte;
use App\Models\Especificacao;
use Illuminate\Http\Request;
use App\Http\Transformers\AcaoTipoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AcaoTipoController extends Controller
{
	public function tipos($acao_tipo_id)
	{
		$acao_tipo = AcaoTipo::findOrFail($id);

		$acao_tipo->fav = !$acao_tipo->fav;
		$acao_tipo->save();

		return redirect()->route('acao_tipo.index');
	}

	public function favoritar($id)
	{
		$acao_tipo = AcaoTipo::findOrFail($id);

		$acao_tipo->fav = !$acao_tipo->fav;
		$acao_tipo->save();

		return redirect()->route('acao_tipo.index');
	}

	public function index()
	{
		return view('acao_tipo.index')->with([
			'acoes_tipos' => AcaoTipo::orderBy('fav', 'desc')->orderBy('nome')->get()
		]);
	}

	public function create() {
		return view('acao_tipo.create');
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$acao_tipo = AcaoTipoTransformer::toInstance($request->all());
			$acao_tipo->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('acao_tipo.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$acao_tipo = AcaoTipo::findOrFail($id);
		return view('acao_tipo.edit')->with([
			'acao_tipo' => $acao_tipo
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$acao_tipo = AcaoTipo::find($id);

		if(isset($acao_tipo)) {
			try {
				DB::beginTransaction();
				$acao_tipo = AcaoTipoTransformer::toInstance($request->all(), $acao_tipo);
				$acao_tipo->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('acao_tipo.index');

	}

	public function destroy($id)
	{
		$acao_tipo = AcaoTipo::find($id);
		try {
			if(isset($acao_tipo)) {
				$acao_tipo->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('acao_tipo.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'codigo' => ['required'],
			'nome' => ['required']
		]);

		if ($validator->fails()) {
			return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
		}
	}
}
