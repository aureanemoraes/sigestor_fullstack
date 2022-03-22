<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\UnidadeGestora;
use App\Models\PlanoEstrategico;
use App\Models\EixoEstrategico;
use App\Models\Dimensao;
use App\Models\Objetivo;
use Illuminate\Http\Request;
use App\Http\Transformers\MetaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MetaController extends Controller
{
	public function index()
	{
		return view('meta.index')->with([
			'metas' => Meta::orderBy('unidade_gestora_id')->get()
		]);
	}

	public function create() {
		return view('meta.create')->with([
            'unidades_gestoras' => UnidadeGestora::all(),
						'planos_estrategicos' => PlanoEstrategico::all(),
						'eixos_estrategicos' => EixoEstrategico::all(),
						'dimensao' => Dimensao::all(),
						'objetivo' => Objetivo::all()
        ]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$meta = MetaTransformer::toInstance($request->all());
			$meta->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('meta.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$meta = Meta::findOrFail($id);
		return view('meta.edit')->with([
			'meta' => $meta,
            'unidades_gestoras' => UnidadeGestora::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$meta = Meta::find($id);

		if(isset($meta)) {
			try {
				DB::beginTransaction();
				$meta = MetaTransformer::toInstance($request->all(), $meta);
				$meta->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('meta.index');

	}

	public function destroy($id)
	{
		$meta = Meta::find($id);
		try {
			if(isset($meta)) {
				$meta->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('meta.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'codigo' => ['required'],
			'nome' => ['required'],
			'unidade_gestora_id' => ['required', 'exists:unidades_gestoras,id']
		]);

		if ($validator->fails()) {
			return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
		}
	}
}
