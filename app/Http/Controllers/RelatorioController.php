<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcaoTipo;
use App\Models\UnidadeGestora;
use App\Models\Instituicao;
use App\Models\Exercicio;
use App\Models\UnidadeAdministrativa;
use App\Models\NaturezaDespesa;

class RelatorioController extends Controller
{
    public function index() {
        return view('relatorio.index');
    }

    public function relatorioSimplificado() 
    {
        return view('relatorio.relatorio-simplificado');
    }
}
