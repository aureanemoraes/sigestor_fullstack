<?php

namespace App\Http\Controllers;

use App\Models\UnidadeAdministrativa;
use App\Models\UnidadeGestora;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Http\Transformers\UnidadeAdministrativaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UnidadeAdministrativaController extends Controller
{
	public function index()
	{
		return view('unidade_administrativa.index')->with([
			'unidades_administrativas' => UnidadeAdministrativa::get()
		]);
	}

	public function create() {
		return view('unidade_administrativa.create')->with([
			'instituicoes' => Instituicao::all(),
			'unidades_gestoras' => UnidadeGestora::all()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$unidade_administrativa = UnidadeAdministrativaTransformer::toInstance($request->all());
			$unidade_administrativa->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('unidade_administrativa.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$unidade_administrativa = UnidadeAdministrativa::findOrFail($id);
		return view('unidade_administrativa.edit')->with([
			'unidade_administrativa' => $unidade_administrativa,
			'instituicoes' => Instituicao::all(),
			'unidades_gestoras' => UnidadeGestora::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$unidade_administrativa = UnidadeAdministrativa::find($id);

		if(isset($unidade_administrativa)) {
			try {
				DB::beginTransaction();
				$unidade_administrativa = UnidadeAdministrativaTransformer::toInstance($request->all(), $unidade_administrativa);
				$unidade_administrativa->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('unidade_administrativa.index');

	}

	public function destroy($id)
	{
		$unidade_administrativa = UnidadeAdministrativa::find($id);
		try {
			if(isset($unidade_administrativa)) {
				$unidade_administrativa->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('unidade_administrativa.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'nome' => ['required'],
			'uasg' => ['required'],
			'instituicao_id' => ['required', 'exists:instituicoes,id'],
			'unidade_gestora_id' => ['required', 'exists:unidades_gestoras,id']
		]);

		if ($validator->fails()) {
			return redirect()->back()
                ->withErrors($validator)
                ->withInput();
		}
	}
}
