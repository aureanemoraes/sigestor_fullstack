<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EixoEstrategicoController;
use App\Http\Controllers\DimensaoController;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\AcaoTipoController;
use App\Http\Controllers\SubnaturezaDespesaController;
use App\Http\Controllers\NaturezaDespesaController;
use App\Http\Controllers\DespesaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('eixo_estrategico/opcoes/{plano_estrategico_id}', [EixoEstrategicoController::class, 'opcoes']);
Route::get('dimensao/opcoes/{eixo_estrategico_id}', [DimensaoController::class, 'opcoes']);
Route::get('objetivo/opcoes/{dimensao_id}', [ObjetivoController::class, 'opcoes']);

Route::get('meta/opcoes/{plano_acao_id}', [MetaController::class, 'opcoes']);
Route::get('subnatureza_despesa/opcoes/{natureza_despesa_id}', [SubnaturezaDespesaController::class, 'opcoes']);
Route::get('meta/{meta_id}', [MetaController::class, 'dados']);
Route::get('acao/options/{id}/{tipo}/{ploa_id}', [AcaoTipoController::class, 'getOptions']);
Route::get('acao/tipos', [AcaoTipoController::class, 'tipos']);
Route::get('natureza_despesa/options/{id}/{acao_id}/{tipo}/{ploa_id}', [NaturezaDespesaController::class, 'getOptions']);

Route::get('despesa/{unidade_administrativa_id}/{ploa_id}', [DespesaController::class, 'getDespesas']);


