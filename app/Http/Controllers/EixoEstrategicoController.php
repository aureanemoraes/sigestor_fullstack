<?php

namespace App\Http\Controllers;

use App\Models\EixoEstrategico;
use App\Models\PlanoEstrategico;
use Illuminate\Http\Request;
use App\Http\Transformers\EixoEstrategicoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EixoEstrategicoController extends Controller
{
	public function opcoes($plano_estrategico_id)
	{
		return EixoEstrategico::select('id', 'nome as text')->where('plano_estrategico_id', $plano_estrategico_id)->get();
	}

	public function index()
	{
		return view('eixo_estrategico.index')->with([
			'eixos_estrategicos' => EixoEstrategico::get()
		]);
	}

	public function create() {
		return view('eixo_estrategico.create')->with([
            'planos_estrategicos' => PlanoEstrategico::all()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$eixo_estrategico = EixoEstrategicoTransformer::toInstance($request->all());
			$eixo_estrategico->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('eixo_estrategico.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$eixo_estrategico = EixoEstrategico::findOrFail($id);
		return view('eixo_estrategico.edit')->with([
			'eixo_estrategico' => $eixo_estrategico,
            'planos_estrategicos' => PlanoEstrategico::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$eixo_estrategico = EixoEstrategico::find($id);

		if(isset($eixo_estrategico)) {
			try {
				DB::beginTransaction();
				$eixo_estrategico = EixoEstrategicoTransformer::toInstance($request->all(), $eixo_estrategico);
				$eixo_estrategico->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('eixo_estrategico.index');

	}

	public function destroy($id)
	{
		$eixo_estrategico = EixoEstrategico::find($id);
		try {
			if(isset($eixo_estrategico)) {
				$eixo_estrategico->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('eixo_estrategico.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'plano_estrategico_id' => ['integer', 'required', 'exists:planos_estrategicos,id']
        ]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
