<?php

namespace App\Http\Controllers;

use App\Models\CertidaoCredito;
use App\Http\Transformers\CertidaoCreditoTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CertidaoCreditoController extends Controller
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
			$certidao_credito = CertidaoCreditoTransformer::toInstance($request->all());
			$certidao_credito->save();

			DB::commit();
		} catch (Exception $ex) {
			DB::rollBack();
		}

        return redirect()->route('credito_planejado.index', ['tipo' => 2, 'ploa' => $ploa]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CertidaoCredito  $certidaoCredito
     * @return \Illuminate\Http\Response
     */
    public function show(CertidaoCredito $certidaoCredito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CertidaoCredito  $certidaoCredito
     * @return \Illuminate\Http\Response
     */
    public function edit(CertidaoCredito $certidaoCredito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CertidaoCredito  $certidaoCredito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CertidaoCredito $certidaoCredito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CertidaoCredito  $certidaoCredito
     * @return \Illuminate\Http\Response
     */
    public function destroy(CertidaoCredito $certidaoCredito)
    {
        //
    }
}
