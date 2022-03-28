<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Http\Transformers\EventoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventoController extends Controller
{
	// public function index(Request $request)
	// {
	// 	if(isset($request->exercicio)) {
	// 		$exercicio_id = $request->exercicio;
	// 		$exercicio = Exercicio::find($exercicio_id);
	// 		$evento = Evento::where('exercicio_id', $exercicio_id)->first();

	// 		return view('evento.index')->with([
	// 			'evento' => $evento,
	// 			'exercicio' => $exercicio
	// 		]);
	// 	}
	// }

	public function create(Request $request) 
	{
		return view('evento.create')->with([
			'agenda' => Agenda::find($request->agenda)
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$evento = EventoTransformer::toInstance($request->all());
			$rules = $this->rules($evento);
			if($rules['status']) {
				$evento->save();
				DB::commit();
			}
			else {
				DB::rollBack();
				session(['error_evento' => $rules['msg']]);
				return redirect()->route('agenda.eventos', $evento->agenda_id);
			}
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('agenda.eventos', $evento->agenda_id);
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$evento = Evento::findOrFail($id);
		return view('evento.edit')->with([
			'evento' => $evento,
			'exercicio' => Exercicio::find($evento->exercicio_id)
		]);
	}

	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$evento = Evento::find($id);

		if(isset($evento)) {
			try {
				DB::beginTransaction();
				$evento = EventoTransformer::toInstance($request->all(), $evento);
				$evento->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('agenda.index', ['exercicio' => $evento->agenda->exercicio_id]);

	}

	public function destroy($id)
	{
		$evento = Evento::find($id);
		try {
			if(isset($evento)) {
				$evento->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('agenda.index', ['exercicio' => $evento->agenda->exercicio_id]);
	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
            'nome' => ['required'],
            'data_inicio' => ['required', 'date'],
            'data_fim' => ['required', 'date', 'after:data_inicio'],
            'agenda_id' => ['integer', 'required', 'exists:agendas,id']
        ]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}

	protected function rules($evento) {
		if($evento->data_inicio >= $evento->agenda->data_inicio && $evento->data_fim <= $evento->agenda->data_fim) {
			$existe = Evento::whereBetween('data_inicio', [$evento->data_inicio, $evento->data_fim])->orWhereBetween('data_fim', [$evento->data_inicio, $evento->data_fim])->exists();
			if(!$existe)
				return [
					'status' => true,
					'msg' => ''
				];
			else 
				return [
					'status' => false,
					'msg' => 'Já existe um evento cadastrado no período inserido.'
				];
		} else
			return [
				'status' => false,
				'msg' => 'O período selecionado é inválido. Por favor, crie um evento dentro do período de vigência da agenda atual.'
			];
	}
}
