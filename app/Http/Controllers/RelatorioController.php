<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcaoTipo;
use App\Models\UnidadeGestora;
use App\Models\Instituicao;
use App\Models\Exercicio;

class RelatorioController extends Controller
{
    public function index() {
        return view('relatorio.index');
    }

    public function relatorio_matriz($instituicao_id, $exercicio_id) {
        $acoes = AcaoTipo::where('fav', 1)->get();
        $instituicao = Instituicao::find($instituicao_id);
        $exercicio = Exercicio::find($exercicio_id);

        $dados = [];

        $unidades_gestoras = UnidadeGestora::where('instituicao_id', $instituicao_id)->get();

        return view('relatorio.matriz')->with([
            'acoes' => $acoes,
            'unidades_gestoras' => $unidades_gestoras,
            'instituicao' => $instituicao,
            'exercicio' => $exercicio
        ]);
    }
}
