<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\ExercicioController;
use App\Http\Controllers\UnidadeGestoraController;
use App\Http\Controllers\UnidadeAdministrativaController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\FonteTipoController;
use App\Http\Controllers\AcaoTipoController;
use App\Http\Controllers\NaturezaDespesaController;
use App\Http\Controllers\SubnaturezaDespesaController;
use App\Http\Controllers\CentroCustoController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('instituicao', InstituicaoController::class);
Route::resource('exercicio', ExercicioController::class);
Route::resource('unidade_gestora', UnidadeGestoraController::class);
Route::resource('unidade_administrativa', UnidadeAdministrativaController::class);
Route::patch('programa/favoritar/{id}', [ProgramaController::class, 'favoritar'])->name('programa.fav');
Route::resource('programa', ProgramaController::class);
Route::resource('fonte_tipo', FonteTipoController::class);
Route::resource('acao_tipo', AcaoTipoController::class);
Route::resource('natureza_despesa', NaturezaDespesaController::class);
Route::resource('subnatureza_despesa', SubnaturezaDespesaController::class);
Route::resource('centro_custo', CentroCustoController::class);







