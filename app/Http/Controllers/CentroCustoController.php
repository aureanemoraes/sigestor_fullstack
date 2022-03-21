<?php

namespace App\Http\Controllers;

use App\Models\CentroCusto;
use Illuminate\Http\Request;
use App\Http\Transformers\CentroCustoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CentroCustoController extends Controller
{
	public function index()
	{
		return view('centro_custo.index')->with([
			'centro_custos' => CentroCusto::orderBy('nome')->get()
		]);
	}

	public function create() {
		return view('centro_custo.create');
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$centro_custo = CentroCustoTransformer::toInstance($request->all());
			$centro_custo->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('centro_custo.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$centro_custo = CentroCusto::findOrFail($id);
		return view('centro_custo.edit')->with([
			'centro_custo' => $centro_custo
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$centro_custo = CentroCusto::find($id);

		if(isset($centro_custo)) {
			try {
				DB::beginTransaction();
				$centro_custo = CentroCustoTransformer::toInstance($request->all(), $centro_custo);
				$centro_custo->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('centro_custo.index');

	}

	public function destroy($id)
	{
		$centro_custo = CentroCusto::find($id);
		try {
			if(isset($centro_custo)) {
				$centro_custo->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('centro_custo.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'nome' => ['required']
		]);

		if ($validator->fails()) {
			return redirect()->back()
                ->withErrors($validator)
                ->withInput();
		}
	}
}
