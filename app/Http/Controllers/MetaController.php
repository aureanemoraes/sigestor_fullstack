<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\UnidadeGestora;
use App\Models\PlanoEstrategico;
use App\Models\PlanoAcao;
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
			'metas' => Meta::all()
		]);
	}

	public function create() {
		return view('meta.create')->with([
				'unidades_gestoras' => UnidadeGestora::all(),
				'planos_estrategicos' => PlanoEstrategico::all(),
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

			if(isset($meta)) {
				if(isset($request->unidade_gestora_id)) {
					if(count($request->unidade_gestora_id) > 0) {
						$meta->responsaveis()->sync($request->unidade_gestora_id);
					}
				} else {
					$meta->responsaveis()->detach();
				}
			}
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
			'unidades_gestoras' => UnidadeGestora::all(),
			'planos_estrategicos' => PlanoEstrategico::all(),
			'eixos_estrategicos' => EixoEstrategico::where('plano_estrategico_id', $meta->objetivo->dimensao->eixo_estrategico->plano_estrategico_id)->get(),
			'dimensoes' => Dimensao::where('eixo_estrategico_id', $meta->objetivo->dimensao->eixo_estrategico_id)->get(),
			'objetivos' => Objetivo::where('dimensao_id', $meta->objetivo->dimensao_id)->get()
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
				if(isset($meta)) {
					if(isset($request->unidade_gestora_id)) {
						if(count($request->unidade_gestora_id) > 0) {
							$meta->responsaveis()->sync($request->unidade_gestora_id);
						}
					} else {
						$meta->responsaveis()->detach();
					}
				}
	
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
		// dd($request->all());
		$validator = Validator::make($request->all(), [
			'nome' => ['required'],
			'descricao' => ['nullable'],
			'tipo' => ['required'],
			'tipo_dado' => ['required'],
			'valor_inicial' => ['required'],
			'valor_final' => ['required'],
			'valor_atingido' => ['nullable'],
			'objetivo_id' => ['required', 'exists:objetivos,id'],
			'unidade_gestora_id.*' => ['required', 'exists:unidades_gestoras,id']
		]);

		if ($validator->fails()) {
			return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
		}
	}
}
