<?php

namespace App\Http\Controllers;

use App\Models\FonteTipo;
use App\Models\GrupoFonte;
use App\Models\Especificacao;
use Illuminate\Http\Request;
use App\Http\Transformers\FonteTipoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FonteTipoController extends Controller
{
	public function index()
	{
		return view('fonte_tipo.index')->with([
			'fontes_tipos' => FonteTipo::get()
		]);
	}

	public function create() {
		return view('fonte_tipo.create')->with([
            'grupos_fontes' => GrupoFonte::all(),
            'especificacoes' => Especificacao::all()
        ]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$fonte_tipo = FonteTipoTransformer::toInstance($request->all());
			$fonte_tipo->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('fonte_tipo.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$fonte_tipo = FonteTipo::findOrFail($id);
		return view('fonte_tipo.edit')->with([
			'fonte_tipo' => $fonte_tipo,
			'grupos_fontes' => GrupoFonte::all(),
			'especificacoes' => Especificacao::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$fonte_tipo = FonteTipo::find($id);

		if(isset($fonte_tipo)) {
			try {
				DB::beginTransaction();
				$fonte_tipo = FonteTipoTransformer::toInstance($request->all(), $fonte_tipo);
				$fonte_tipo->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('fonte_tipo.index');

	}

	public function destroy($id)
	{
		$fonte_tipo = FonteTipo::find($id);
		try {
			if(isset($fonte_tipo)) {
				$fonte_tipo->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('fonte_tipo.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'grupo_fonte_id' => ['required', 'exists:grupos_fontes,id'],
			'especificacao_id' => ['required', 'exists:especificacoes,id'],
			'nome' => ['required']
		]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
