<?php

namespace App\Http\Controllers;

use App\Models\Exercicio;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Http\Transformers\ExercicioTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExercicioController extends Controller
{
	public function index()
	{
		return view('exercicio.index')->with([
			'instituicoes' => Exercicio::paginate()
		]);
	}

	public function create() {
		return view('exercicio.create')->with([
			'instituicoes' => Instituicao::all()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$exercicio = ExercicioTransformer::toInstance($request->all());
			$exercicio->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('exercicio.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$exercicio = Exercicio::findOrFail($id);
		return view('exercicio.edit')->with([
			'exercicio' => $exercicio,
			'instituicoes' => Instituicao::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$exercicio = Exercicio::find($id);

		if(isset($exercicio)) {
			try {
				DB::beginTransaction();
				$exercicio = ExercicioTransformer::toInstance($request->all(), $exercicio);
				$exercicio->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('exercicio.index');

	}

	public function destroy($id)
	{
		$exercicio = Exercicio::find($id);
		try {
			if(isset($exercicio)) {
				$exercicio->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('exercicio.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'data_inicio' => ['required'],
            'data_fim' => ['required'],
            'instituicao_id' => ['integer', 'required', 'exists:instituicoes,id']
        ]);

				// dd($request, $validator->fails());

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
