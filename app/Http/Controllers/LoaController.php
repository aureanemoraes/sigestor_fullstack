<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loa;
use App\Models\Exercicio;
use App\Models\Ploa;
use App\Models\Programa;
use App\Models\FonteTipo;
use App\Models\AcaoTipo;
use App\Models\Instituicao;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Transformers\LoaTransformer;

class LoaController extends Controller
{
    public function loas($ploa_id) 
    {
        $loas = Loa::where('ploa_id', $ploa_id)->get();

        return view('loa.loas')->with([
            'loas' => $loas
        ]);
    }

    public function lista()
    {
        $exercicios = Exercicio::all()->append('status');

        return view('loa.lista')->with([
            'exercicios' => $exercicios
        ]);
    }

    public function index(Request $request)
    {
        if(isset($request->ploa)) {
            $exercicio = Exercicio::find($request->ploa);

            if(isset($exercicio)) {
                // Total da LOA do EXERCÍCIO
                $limite_planejado = 0;
                // VALOR TOTAL RECEBIDO EM TODOS OS PROGRAMAS
                $limite_recebido = 0;
                // VALOR A RECEBER EM TODOS OS PROGRAMAS
                $limite_a_receber = 0;

                if(!isset($exercicio_id)) {
                    $exercicio_selecionado = Exercicio::all()->last();
                    $exercicio_id = $exercicio_selecionado->id;
                }
                else 
                    $exercicio_selecionado = Exercicio::find($exercicio_id);

                $ploas = Ploa::where('exercicio_id', $exercicio_id)->get();

                if(count($ploas) > 0) {
                    foreach($ploas as $ploa) {
                        if(count($ploa->ploas_gestoras) > 0) {
                            $limite_recebido += $ploa->loas()->sum('valor');
                        }
                    }
                }

                $limite_planejado = $ploas->sum('valor');

                $limite_a_receber = $limite_planejado - $limite_recebido;

                $programas_ploa = Programa::whereHas(
                    'ploas', function ($query) use($exercicio_id) {
                        $query->where('exercicio_id', $exercicio_id);
                    }
                )->get();

                return view('loa.index')->with([
                    'programas_ploa' => $programas_ploa,
                    'programas' => Programa::all(),
                    'fontes' => FonteTipo::all(),
                    'acoes' => AcaoTipo::where('fav', 1)->get(),
                    'instituicoes' => Instituicao::all(),
                    'exercicio' => $exercicio,
                    'total_ploa' => $limite_planejado,
                    'limite_planejado' => $limite_planejado,
                    'limite_recebido' => $limite_recebido,
                    'limite_a_receber' => $limite_a_receber
                ]);
            }
        }
    }

    public function create(Request $request)
    {
        if(isset($request->ploa)) {
            $ploa = Ploa::find($request->ploa);

            if(isset($ploa)) {
                return view('loa.create')->with([
                    'ploa' => $ploa
                ]);
            }
        }
    }

    public function store(Request $request)
	{
		$invalido = $this->validation($request);

		if($invalido) return $invalido;
        
		try {
			DB::beginTransaction();
			$loa = LoaTransformer::toInstance($request->all());
			$rules = $this->rules($loa);
			if($rules['status']) {
				$loa->save();
				DB::commit();
			} else 	{
				DB::rollBack();
				session(['error_loa' => $rules['msg']]);
				return redirect()->route('loa.create', ['ploa' => $loa->ploa_id]);
			}

		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('loa.index', ['ploa' => $loa->ploa_id]);
	}

    protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'valor' => ['required'],
			'ploa_id' => ['integer', 'required', 'exists:ploas,id'],
			'tipo' => ['required'],
			'data_recebimento' => ['required'],
			'descricao' => ['nullable'],
		]);

		if ($validator->fails()) {
			return redirect()->back()
									->withErrors($validator)
									->withInput();
		}
	}

    protected function rules($loa) {
        // verificar quanto falta receber: valor_planejado - valor recebido
        // verificar se o valor recebido é menor que o valor que ainda falta receber

        $ploa = Ploa::find($loa->ploa_id);

        if(isset($ploa)) {
            if($loa->tipo == 'entrada') {
                $loas = Loa::where('ploa_id', $loa->ploa_id)->where('tipo', 'entrada')->get();

                $valor_recebido = count($loas) > 0 ? $loas->sum('valor') : 0;
                $valor_planejado = $ploa->valor;

                $valor_a_receber = $valor_planejado - $valor_recebido;

                if($loa->valor <= $valor_a_receber)
                    return [
                        'status' => true,
                        'msg' => ''
                    ];
                else
                    return [
                        'status' => false,
                        'msg' => 'O valor recebido é maior que o valor planejado.'
                    ];
            }
        }
	}
}
