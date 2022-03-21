<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;
use App\Http\Transformers\ProgramaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProgramaController extends Controller
{
	public function favoritar($id)
	{
		$programa = Programa::findOrFail($id);

		$programa->fav = !$programa->fav;
		$programa->save();

		return redirect()->route('programa.index');
	}

	public function index()
	{
		return view('programa.index')->with([
			'programas' => Programa::orderBy('fav', 'desc')->get()
		]);
	}

	public function create() {
		return view('programa.create');
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$programa = ProgramaTransformer::toInstance($request->all());
			$programa->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('programa.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$programa = Programa::findOrFail($id);
		return view('programa.edit')->with([
			'programa' => $programa
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$programa = Programa::find($id);

		if(isset($programa)) {
			try {
				DB::beginTransaction();
				$programa = ProgramaTransformer::toInstance($request->all(), $programa);
				$programa->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('programa.index');

	}

	public function destroy($id)
	{
		$programa = Programa::find($id);
		try {
			if(isset($programa)) {
				$programa->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('programa.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'nome' => ['required'],
			'codigo' => ['required']
		]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
