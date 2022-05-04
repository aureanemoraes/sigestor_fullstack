<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaGestora;
use App\Models\Exercicio;
use App\Models\PloaGestora;
use App\Models\Programa;
use App\Models\FonteTipo;
use App\Models\AcaoTipo;
use App\Models\Instituicao;
use App\Models\UnidadeGestora;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Transformers\LoaGestoraTransformer;

class LoaGestoraController extends Controller
{
    public function loas_gestoras($ploa_id) 
    {
        $loas_gestoras = LoaGestora::where('ploa_id', $ploa_id)->get();

        return view('loa_gestora.loas_gestoras')->with([
            'loas_gestoras' => $loas_gestoras
        ]);
    }

    public function lista()
    {
        $exercicios = Exercicio::all()->append('status');

        return view('loa_gestora.lista')->with([
            'exercicios' => $exercicios
        ]);
    }

    public function index(Request $request)
    {
        if(isset($request->ploa) && isset($request->unidade_gestora)) {
            $exercicio = Exercicio::find($request->ploa);
            $unidade_selecionada = UnidadeGestora::find($request->unidade_gestora);

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

                $ploas_gestoras = PloaGestora::whereHas(
                    'ploa', function($query) use($exercicio) {
                        $query->where('exercicio_id', $exercicio->id);
                    }
                )
                ->where('unidade_gestora_id', $unidade_selecionada->id)
                ->get();

                if(count($ploas_gestoras) > 0) {
                    foreach($ploas_gestoras as $ploa_gestora) {
                        if(count($ploa_gestora->ploas_administrativas) > 0) {
                            foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa) {
                                if(count($ploa_administrativa->despesas) > 0) {
                                    foreach($ploa_administrativa->despesas as $despesa) {
                                        $credito_planejado = $despesa->creditos_planejados()->where('unidade_gestora', 'deferido')->where('instituicao', 'deferido')->first(); 
                                        $limite_recebido += isset($credito_planejado) ? $credito_planejado->valor_total : 0;
                                    }
                                }
                            }
                        }
                    }
                }

                $limite_planejado = $ploas_gestoras->sum('valor');

                $limite_a_receber = $limite_planejado - $limite_recebido;

                $programas_ploa = Programa::whereHas(
                    'ploas', function ($query) use($exercicio_id, $unidade_selecionada) {
                        $query->where('exercicio_id', $exercicio_id);
                        $query->whereHas(
                            'ploas_gestoras', function($query) use($unidade_selecionada){
                                $query->where('unidade_gestora_id', $unidade_selecionada->id);
                            });
                    }
                )->get();

                return view('loa_gestora.index')->with([
                    'programas_ploa' => $programas_ploa,
                    'programas' => Programa::all(),
                    'ploas_gestoras' => $ploas_gestoras,
                    'fontes' => FonteTipo::all(),
                    'acoes' => AcaoTipo::where('fav', 1)->get(),
                    'instituicoes' => Instituicao::all(),
                    'unidades_gestoras' => UnidadeGestora::all(),
                    'unidade_selecionada' => $unidade_selecionada,
                    'exercicio' => $exercicio,
                    'total_ploa' => $limite_planejado,
                    'limite_planejado' => $limite_planejado,
                    'limite_recebido' => $limite_recebido,
                    'limite_a_receber' => $limite_a_receber
                ]);
            }
        } else if (isset($request->ploa)) {
            $exercicio = Exercicio::find($request->ploa);

            return view('loa_gestora.index')->with([
                'unidades_gestoras' => UnidadeGestora::all(),
                'exercicio' => $exercicio						
            ]);
        }
    }

    public function create(Request $request)
    {
        if(isset($request->ploa)) {
            $ploa = PloaGestora::find($request->ploa);

            if(isset($ploa)) {
                return view('loa_gestora.create')->with([
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
			$loa = LoaGestoraTransformer::toInstance($request->all());
			$rules = $this->rules($loa);
			if($rules['status']) {
				$loa->save();
				DB::commit();
			} else 	{
				DB::rollBack();
				session(['error_loa' => $rules['msg']]);
				return redirect()->route('loa_gestora.create', ['ploa' => $loa->ploa_id]);
			}

		} catch (Exception $ex) {
			DB::rollBack();
		}

		return redirect()->route('loa_gestora.index', ['ploa' => $loa->ploa_id]);
	}

    protected function validation($request) 
	{
		$validator = Validator::make($request->all(), [
			'valor' => ['required'],
			'ploa_id' => ['integer', 'required', 'exists:ploas_gestoras,id'],
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

        $ploa = PloaGestora::find($loa->ploa_id);

        if(isset($ploa)) {
            if($loa->tipo == 'entrada') {
                $loas_gestoras = LoaGestora::where('ploa_id', $loa->ploa_id)->where('tipo', 'entrada')->get();

                $valor_recebido = count($loas_gestoras) > 0 ? $loas_gestoras->sum('valor') : 0;
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
