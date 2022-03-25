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
	public function index(Request $request)
	{
		if(isset($request->objetivo)) {
			$objetivo_id = $request->objetivo;
			$metas = Meta::where('objetivo_id', $objetivo_id)->get();
			$objetivo = Objetivo::find($objetivo_id);
			$plano_estrategico = $objetivo->dimensao->eixo_estrategico->plano_estrategico->nome;
			$eixo_estrategico = $objetivo->dimensao->eixo_estrategico->nome;
			$dimensao = $objetivo->dimensao->nome;

			return view('meta.index')->with([
				'metas' => $metas,
				'objetivo' => $objetivo,
				'plano_estrategico' => $plano_estrategico,
				'eixo_estrategico' => $eixo_estrategico,
				'dimensao' => $dimensao
			]);
		}
	}
		

	public function create(Request $request) {
		if($request->objetivo) {
			$objetivo_id = $request->objetivo;
			$objetivo = Objetivo::find($objetivo_id);
			$plano_estrategico_id = $objetivo->dimensao->eixo_estrategico->plano_estrategico_id;
			$plano_estrategico = $objetivo->dimensao->eixo_estrategico->plano_estrategico->nome;
			$eixo_estrategico = $objetivo->dimensao->eixo_estrategico->nome;
			$dimensao = $objetivo->dimensao->nome;
			$planos_acoes = PlanoAcao::where('plano_estrategico_id', $plano_estrategico_id)->get();

			return view('meta.create')->with([
				'unidades_gestoras' => UnidadeGestora::all(),
				'objetivo' => $objetivo,
				'plano_estrategico' => $plano_estrategico,
				'eixo_estrategico' => $eixo_estrategico,
				'dimensao' => $dimensao,
				'planos_acoes' => $planos_acoes
			]);
		}
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

		return redirect()->route('meta.index', ['objetivo' => $meta->objetivo_id]);
	}

	public function show($id)
	{
	}

	public function edit($id, Request $request) {
		$meta = Meta::findOrFail($id);
		if($request->objetivo) {
			$objetivo_id = $request->objetivo;
			$objetivo = Objetivo::find($objetivo_id);
			$plano_estrategico_id = $objetivo->dimensao->eixo_estrategico->plano_estrategico_id;
			$plano_estrategico = $objetivo->dimensao->eixo_estrategico->plano_estrategico->nome;
			$eixo_estrategico = $objetivo->dimensao->eixo_estrategico->nome;
			$dimensao = $objetivo->dimensao->nome;
			$planos_acoes = PlanoAcao::where('plano_estrategico_id', $plano_estrategico_id)->get();

			return view('meta.edit')->with([
				'meta' => $meta,
				'unidades_gestoras' => UnidadeGestora::all(),
				'objetivo' => $objetivo,
				'plano_estrategico' => $plano_estrategico,
				'eixo_estrategico' => $eixo_estrategico,
				'dimensao' => $dimensao,
				'planos_acoes' => $planos_acoes
			]);
		}
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

		return redirect()->route('meta.index', ['objetivo' => $meta->objetivo_id]);
	}

	public function destroy($id)
	{
		$meta = Meta::find($id);
		try {
			if(isset($meta)) {
				$meta->responsaveis()->detach();
				$meta->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('meta.index', ['objetivo' => $meta->objetivo_id]);
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
