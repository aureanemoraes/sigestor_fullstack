<?php

namespace App\Http\Controllers;

use App\Models\SubnaturezaDespesa;
use App\Models\NaturezaDespesa;
use App\Models\GrupoFonte;
use App\Models\Especificacao;
use Illuminate\Http\Request;
use App\Http\Transformers\SubnaturezaDespesaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubnaturezaDespesaController extends Controller
{
	public function index()
	{
		return view('subnatureza_despesa.index')->with([
			'subnaturezas_despesas' => SubnaturezaDespesa::orderBy('natureza_despesa_id')->get()
		]);
	}

	public function create() {
		return view('subnatureza_despesa.create')->with([
            'naturezas_despesas' => NaturezaDespesa::all()
        ]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$subnatureza_despesa = SubnaturezaDespesaTransformer::toInstance($request->all());
			$subnatureza_despesa->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('subnatureza_despesa.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$subnatureza_despesa = SubnaturezaDespesa::findOrFail($id);
		return view('subnatureza_despesa.edit')->with([
			'subnatureza_despesa' => $subnatureza_despesa,
            'naturezas_despesas' => NaturezaDespesa::all()
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$subnatureza_despesa = SubnaturezaDespesa::find($id);

		if(isset($subnatureza_despesa)) {
			try {
				DB::beginTransaction();
				$subnatureza_despesa = SubnaturezaDespesaTransformer::toInstance($request->all(), $subnatureza_despesa);
				$subnatureza_despesa->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('subnatureza_despesa.index');

	}

	public function destroy($id)
	{
		$subnatureza_despesa = SubnaturezaDespesa::find($id);
		try {
			if(isset($subnatureza_despesa)) {
				$subnatureza_despesa->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('subnatureza_despesa.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'codigo' => ['required'],
			'nome' => ['required'],
			'natureza_despesa_id' => ['required', 'exists:naturezas_despesas,id']
		]);

		if ($validator->fails()) {
			return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
		}
	}
}
