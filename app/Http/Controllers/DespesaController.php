<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\PloaAdministrativa;
use App\Models\NaturezaDespesa;
use App\Models\PlanoAcao;
use App\Models\CentroCusto;
use App\Models\DespesaModelo;
use Illuminate\Http\Request;

class DespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        if(isset($request->ploa_administrativa)) {
            $ploa_administrativa_id = $request->ploa_administrativa;
            $ploa_administrativa = PloaAdministrativa::find($ploa_administrativa_id); 
            $despesas_modelos = DespesaModelo::all();

            return view('despesa.create')->with([
                'despesas_modelos' => $despesas_modelos,
                'ploa_administrativa' => $ploa_administrativa,
                'planos_acoes' => PlanoAcao::all(),
                'naturezas_despesas' => NaturezaDespesa::where('fav', 1)->get(),
                'centros_custos' => CentroCusto::all()
            ]);
        }
		
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
