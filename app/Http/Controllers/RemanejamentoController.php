<?php

namespace App\Http\Controllers;

use App\Models\Remanejamento;
use App\Http\Transformers\RemanejamentoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RemanejamentoController extends Controller
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
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ploa = $request->exercicio_id;

		try {
			DB::beginTransaction();
			$remanejamento = RemanejamentoTransformer::toInstance($request->all());
			$remanejamento->save();

			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

        return redirect()->route('credito_planejado.index', ['tipo' => 2, 'ploa' => $ploa]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Remanejamento  $certidaoCredito
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $remanejamento = Remanejamento::find($id);

        if(isset($remanejamento)) {
            return view('remanejamento.show')->with([
                'remanejamento' => $remanejamento
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remanejamento  $certidaoCredito
     * @return \Illuminate\Http\Response
     */
    public function edit(Remanejamento $certidaoCredito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Remanejamento  $certidaoCredito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Remanejamento $certidaoCredito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remanejamento  $certidaoCredito
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remanejamento $certidaoCredito)
    {
        //
    }
}
