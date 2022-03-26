<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Exercicio;
use Illuminate\Http\Request;
use App\Http\Transformers\AgendaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
	public function index(Request $request)
	{
		if(isset($request->exercicio)) {
			$exercicio_id = $request->exercicio;
			$exercicio = Exercicio::find($exercicio_id);
			$agenda = Agenda::where('exercicio_id', $exercicio_id)->first();

			return view('agenda.index')->with([
				'agenda' => $agenda,
				'exercicio' => $exercicio
			]);
		}
	}

	public function create(Request $request) {
		return view('agenda.create')->with([
			'exercicio' => Exercicio::find($request->exercicio)
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$agenda = AgendaTransformer::toInstance($request->all());
			$agenda->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('agenda.index', ['exercicio' => $agenda->exercicio_id]);
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$agenda = Agenda::findOrFail($id);
		return view('agenda.edit')->with([
			'agenda' => $agenda,
			'exercicio' => Exercicio::find($agenda->exercicio_id)
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$agenda = Agenda::find($id);

		if(isset($agenda)) {
			try {
				DB::beginTransaction();
				$agenda = AgendaTransformer::toInstance($request->all(), $agenda);
				$agenda->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('agenda.index', ['exercicio' => $agenda->exercicio_id]);

	}

	public function destroy($id)
	{
		$agenda = Agenda::find($id);
		try {
			if(isset($agenda)) {
				$agenda->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('agenda.index', ['exercicio' => $agenda->exercicio_id]);

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'data_inicio' => ['required'],
            'data_fim' => ['required'],
            'exercicio_id' => ['integer', 'required', 'exists:exercicios,id']
        ]);

				// dd($request, $validator->fails());

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
