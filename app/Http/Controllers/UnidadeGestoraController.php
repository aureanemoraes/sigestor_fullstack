<?php

namespace App\Http\Controllers;

use App\Models\UnidadeGestora;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Http\Transformers\UnidadeGestoraTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UnidadeGestoraController extends Controller
{
	public function index()
	{
		return view('unidade_gestora.index')->with([
			'unidades_gestoras' => UnidadeGestora::paginate()
		]);
	}

	public function create() {
		return view('unidade_gestora.create')->with([
			'instituicoes' => Instituicao::all()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$unidade_gestora = UnidadeGestoraTransformer::toInstance($request->all());
			$unidade_gestora->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('unidade_gestora.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$unidade_gestora = UnidadeGestora::findOrFail($id);
		return view('unidade_gestora.edit')->with([
			'unidade_gestora' => $unidade_gestora,
			'instituicoes' => Instituicao::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$unidade_gestora = UnidadeGestora::find($id);

		if(isset($unidade_gestora)) {
			try {
				DB::beginTransaction();
				$unidade_gestora = UnidadeGestoraTransformer::toInstance($request->all(), $unidade_gestora);
				$unidade_gestora->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('unidade_gestora.index');

	}

	public function destroy($id)
	{
		$unidade_gestora = UnidadeGestora::find($id);
		try {
			if(isset($unidade_gestora)) {
				$unidade_gestora->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('unidade_gestora.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'nome' => ['required'],
			'cnpj' => ['required'],
			'uasg' => ['required'],
			'instituicao_id' => ['required', 'exists:instituicoes,id']
		]);

		if ($validator->fails()) {
			return redirect()->back()
                ->withErrors($validator)
                ->withInput();
		}
	}
}
