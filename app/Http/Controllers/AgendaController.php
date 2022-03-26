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
		return view('agenda.index')->with([
			'agendas' => Agenda::all()
		]);
	}

	public function create() {
		return view('agenda.create')->with([
			'exercicios' => Exercicio::all()
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

		return redirect()->route('agenda.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$agenda = Agenda::findOrFail($id);
		return view('agenda.edit')->with([
			'agenda' => $agenda,
			'exercicios' => Exercicio::all()
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

		return redirect()->route('agenda.index');

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

		return redirect()->route('agenda.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'data_inicio' => ['required'],
            'data_fim' => ['required'],
            'status' => ['required'],
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
