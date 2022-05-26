<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instituicao;
use App\Models\UnidadeGestora;
use App\Models\UnidadeAdministrativa;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	public function updatePerfil(Request $request, $id) {
		$invalido = $this->validation($request, 'updatePerfil');

		if($invalido) return $invalido;
		
		$user = User::find($id);

		if(isset($user)) {
			try {
				DB::beginTransaction();
				$user = UserTransformer::toInstance($request->all(), $user);

				$salvo = $user->save();
				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('user.show', $id);
	}

	public function index(Request $request)
	{
		return view('user.index')->with([
			'users' => User::all()
		]);
	}

	public function create() {
		return view('user.create')->with([
			'unidades_gestoras' => UnidadeGestora::all()
		]);
	}

	public function store(Request $request)
	{

		$invalido = $this->validation($request);

		if($invalido) return $invalido;

		try {
			DB::beginTransaction();
			$user = UserTransformer::toInstance($request->all());
			$salvo = $user->save();

			if($salvo) {
				switch($user->perfil) {
					case 'institucional':
						$user->vinculos()->create([
							'instituicao_id' => Instituicao::first()->id
						]);
						break;
					case 'gestor':
						if(count($request->unidade_gestora_id) > 0) {
							foreach($request->unidade_gestora_id as $unidade_gestora_id) {
								$user->vinculos()->create([
									'unidade_gestora_id' => $unidade_gestora_id
								]);
							}
						}
						break;
					case 'administrativo':
						if(count($request->unidade_administrativa_id) > 0) {
							foreach($request->unidade_administrativa_id as $unidade_administrativa_id) {
								$user->vinculos()->create([
									'unidade_administrativa_id' => $unidade_administrativa_id
								]);
							}
						}
						break;
				}
			}
 
			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('user.index');
	}

	public function show($id)
	{
		$user = User::findOrFail($id);
		
		return view('user.show')->with([
			'user' => $user
		]);
	}

	public function edit($id) {
		$user = User::findOrFail($id);
		$user->setAppends(['unidades_administrativas']);

		// dd($user->toArray());
		$unidades_gestoras = [];
		$unidades_administrativas = [];
		$unidades_gestoras_ids = [];

		if($user->perfil == 'gestor' || $user->perfil == 'administrativo') {
			$unidades_gestoras = UnidadeGestora::all();
		}

		if($user->perfil == 'administrativo') {
			$unidades_gestoras_ids = UnidadeAdministrativa::whereIn('id', $user->unidades_administrativas)->pluck('unidade_gestora_id')->toArray();

			$unidades_administrativas = UnidadeAdministrativa::whereIn('unidade_gestora_id', $unidades_gestoras_ids)->get();

		}

		return view('user.edit')->with([
			'user' => $user,
			'instituicoes' => Instituicao::all(),
			'unidades_gestoras' => $unidades_gestoras,
			'unidades_administrativas' => $unidades_administrativas,
			'unidades_gestoras_ids' => $unidades_gestoras_ids
		]);
	}


	public function update(Request $request, $id)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
		
		$user = User::find($id);

		if(isset($user)) {
			try {
				DB::beginTransaction();
				$user = UserTransformer::toInstance($request->all(), $user);

				$salvo = $user->save();

				if($salvo) {
					$user->vinculos()->delete();
					switch($user->perfil) {
						case 'institucional':
							$user->vinculos()->create([
								'instituicao_id' => Instituicao::first()->id
							]);
							break;
						case 'gestor':
							if(count($request->unidade_gestora_id) > 0) {
								foreach($request->unidade_gestora_id as $unidade_gestora_id) {
									$user->vinculos()->create([
										'unidade_gestora_id' => $unidade_gestora_id
									]);
								}
							}
							break;
						case 'administrativo':
							if(count($request->unidade_administrativa_id) > 0) {
								foreach($request->unidade_administrativa_id as $unidade_administrativa_id) {
									$user->vinculos()->create([
										'unidade_administrativa_id' => $unidade_administrativa_id
									]);
								}
							}
							break;
					}
				}

				DB::commit();

			} catch (Exception $ex) {
				DB::rollBack();
			}
		}

		return redirect()->route('user.index');

	}

	public function destroy($id)
	{
		$user = User::find($id);
		try {
			if(isset($user)) {
				$user->vinculos()->delete();
				$user->delete();
			} 
		} catch(Exception $ex) {
		}

		return redirect()->route('user.index');

	}

	protected function validation($request, $tipo=null) 
	{
		if(isset($tipo) && $tipo == 'updatePerfil') {
			$validator = Validator::make($request->all(), [
				'nome' => ['required'],
				'cpf' => ['required'],
				'matricula' => ['required'],
				'titulacao' => ['required']
			]);
		} else {
			$validator = Validator::make($request->all(), [
				'nome' => ['required'],
				'cpf' => ['required'],
				'matricula' => ['required'],
				'perfil' => ['required'],
				'titulacao' => ['required'],
				'unidade_gestora_id' => ['exists:unidades_gestoras,id'],
				'unidade_administrativa_id' => ['exists:unidades_administrativas,id']
			]);
		}
		// dd($request, $validator->fails());
		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}
}
