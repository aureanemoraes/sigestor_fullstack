<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EixoEstrategicoController;
use App\Http\Controllers\DimensaoController;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\MetaController;

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
Route::get('meta/{meta_id}', [MetaController::class, 'dados']);

