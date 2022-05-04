<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaAdministrativa;
use App\Models\PloaAdministrativa;
use App\Models\Exercicio;
use App\Models\Ploa;
use App\Models\Programa;
use App\Models\FonteTipo;
use App\Models\AcaoTipo;
use App\Models\Instituicao;
use App\Models\UnidadeAdministrativa;
use App\Models\NaturezaDespesa;

class LoaAdministrativaController extends Controller
{
    public function lista()
    {
        $exercicios = Exercicio::all()->append('status');

        return view('loa_administrativa.lista')->with([
            'exercicios' => $exercicios
        ]);
    }

    public function index(Request $request)
    {
        if(isset($request->ploa)) {
            $exercicio = Exercicio::find($request->ploa);
            $unidades_administrativas = UnidadeAdministrativa::all();
            $unidade_selecionada = isset($request->unidade_administrativa) ?UnidadeAdministrativa::find($request->unidade_administrativa) : null;
            $dados = [];
            
            if(isset($exercicio) && isset($unidade_selecionada)) {
                // $acoes = AcaoTipo::whereHas('ploas', function($query) use($unidade_selecionada, $exercicio) {
                //     $query->where('exercicio_id', $exercicio->id);
                //     $query->whereHas('ploas_gestoras', function($query) use($unidade_selecionada, $exercicio) {
                //         $query->whereHas('ploas_administrativas', function($query) use($unidade_selecionada, $exercicio) {
                //             $query->where('unidade_administrativa_id', $unidade_selecionada->id);
                //         });
                //     });
                // })
                // ->get();

                $naturezas_despesas = NaturezaDespesa::whereHas('despesas', function ($query) use($unidade_selecionada, $exercicio){
                    $query->whereHas('ploa_administrativa', function($query) use($unidade_selecionada, $exercicio) {
                        $query->where('unidade_administrativa_id', $unidade_selecionada->id);
                        $query->whereHas('ploa_gestora', function($query) use($unidade_selecionada, $exercicio) {
                            $query->whereHas('ploa', function($query) use($unidade_selecionada, $exercicio) {
                                $query->where('exercicio_id', $exercicio->id);
                            });
                        });
                    });
                })
                ->get();

                $ploas_administrativas = PloaAdministrativa::where('unidade_administrativa_id', $unidade_selecionada->id)->get();
                
                // $dados['acoes'] = $acoes;
                $dados['naturezas_despesas'] = $naturezas_despesas;
                $dados['ploas_administrativas'] = $ploas_administrativas;
            } else if(isset($exercicio)) {

            }

            $dados['unidades_administrativas'] = $unidades_administrativas;
            $dados['unidade_selecionada'] = $unidade_selecionada;
            $dados['exercicio'] = $exercicio;

            return view('loa_administrativa.index')->with($dados);
        }
    }
}
