<?php

namespace App\Http\Controllers;

use App\Models\PlanoEstrategico;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Http\Transformers\PlanoEstrategicoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlanoEstrategicoController extends Controller
{
	public function index()
	{
		return view('plano_estrategico.index')->with([
			'planos_estrategicos' => PlanoEstrategico::get()
		]);
	}

	public function create() {
		return view('plano_estrategico.create')->with([
			'instituicoes' => Instituicao::all()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$plano_estrategico = PlanoEstrategicoTransformer::toInstance($request->all());
			$plano_estrategico->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('plano_estrategico.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$plano_estrategico = PlanoEstrategico::findOrFail($id);
		return view('plano_estrategico.edit')->with([
			'plano_estrategico' => $plano_estrategico,
			'instituicoes' => Instituicao::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$plano_estrategico = PlanoEstrategico::find($id);

		if(isset($plano_estrategico)) {
			try {
				DB::beginTransaction();
				$plano_estrategico = PlanoEstrategicoTransformer::toInstance($request->all(), $plano_estrategico);
				$plano_estrategico->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('plano_estrategico.index');

	}

	public function destroy($id)
	{
		$plano_estrategico = PlanoEstrategico::find($id);
		try {
			if(isset($plano_estrategico)) {
				$plano_estrategico->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('plano_estrategico.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'data_inicio' => ['required'],
            'data_fim' => ['required'],
            'instituicao_id' => ['integer', 'required', 'exists:instituicoes,id']
        ]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
