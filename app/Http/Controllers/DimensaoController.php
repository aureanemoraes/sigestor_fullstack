<?php

namespace App\Http\Controllers;

use App\Models\Dimensao;
use App\Models\Instituicao;
use App\Models\PlanoEstrategico;
use App\Models\EixoEstrategico;
use Illuminate\Http\Request;
use App\Http\Transformers\DimensaoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DimensaoController extends Controller
{
	public function index()
	{
		return view('dimensao.index')->with([
			'dimensoes' => Dimensao::get()
		]);
	}

	public function create() {
		return view('dimensao.create')->with([
            'planos_estrategicos' => PlanoEstrategico::all()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$dimensao = DimensaoTransformer::toInstance($request->all());
			$dimensao->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('dimensao.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$dimensao = Dimensao::findOrFail($id);
		return view('dimensao.edit')->with([
			'dimensao' => $dimensao,
			'planos_estrategicos' => PlanoEstrategico::all(),
			'eixos_estrategicos' => EixoEstrategico::where('plano_estrategico_id', $dimensao->eixo_estrategico->plano_estrategico_id)->get()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$dimensao = Dimensao::find($id);

		if(isset($dimensao)) {
			try {
				DB::beginTransaction();
				$dimensao = DimensaoTransformer::toInstance($request->all(), $dimensao);
				$dimensao->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('dimensao.index');

	}

	public function destroy($id)
	{
		$dimensao = Dimensao::find($id);
		try {
			if(isset($dimensao)) {
				$dimensao->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('dimensao.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'eixo_estrategico_id' => ['integer', 'required', 'exists:eixos_estrategicos,id']
        ]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
