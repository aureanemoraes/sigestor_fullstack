<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Http\Transformers\InstituicaoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InstituicaoController extends Controller
{
	public function index()
	{
		return view('instituicao.index')->with([
			'instituicoes' => Instituicao::get()
		]);
	}

	public function create() {
		return view('instituicao.create');
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$instituicao = InstituicaoTransformer::toInstance($request->all());
			$instituicao->save();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('instituicao.index');
	}

	public function show($id)
	{
	}

	public function edit($id) {
		$instituicao = Instituicao::findOrFail($id);
		return view('instituicao.edit')->with([
			'instituicao' => $instituicao
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$instituicao = Instituicao::find($id);

		if(isset($instituicao)) {
			try {
				DB::beginTransaction();
				$instituicao = InstituicaoTransformer::toInstance($request->all(), $instituicao);
				$instituicao->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('instituicao.index');

	}

	public function destroy($id)
	{
		$instituicao = Instituicao::find($id);
		try {
			if(isset($instituicao)) {
				$instituicao->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('instituicao.index');

	}

	protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'nome' => ['required'],
			'cnpj' => ['required'],
			'ugr' => ['required']
		]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
