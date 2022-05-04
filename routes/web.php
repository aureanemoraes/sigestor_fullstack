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
use App\Http\Controllers\PlanoEstrategicoController;
use App\Http\Controllers\PlanoAcaoController;
use App\Http\Controllers\EixoEstrategicoController;
use App\Http\Controllers\DimensaoController;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PloaController;
use App\Http\Controllers\PloaGestoraController;
use App\Http\Controllers\PloaAdministrativaController;
use App\Http\Controllers\DespesaModeloController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\LoaController;
use App\Http\Controllers\LoaAdministrativaController;
use App\Http\Controllers\CreditoPlanejadoController;
use App\Http\Controllers\LoaGestoraController;

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
    return view('public.home');
});

Route::get('/inicio', function () {
    return view('blank');
});

Route::resource('instituicao', InstituicaoController::class);
Route::resource('exercicio', ExercicioController::class);
Route::resource('unidade_gestora', UnidadeGestoraController::class);
Route::resource('unidade_administrativa', UnidadeAdministrativaController::class);
Route::patch('programa/favoritar/{id}', [ProgramaController::class, 'favoritar'])->name('programa.fav');
Route::resource('programa', ProgramaController::class);
Route::resource('fonte_tipo', FonteTipoController::class);
Route::patch('acao_tipo/favoritar/{id}', [AcaoTipoController::class, 'favoritar'])->name('acao_tipo.fav');
Route::resource('acao_tipo', AcaoTipoController::class);
Route::patch('natureza_despesa/favoritar/{id}', [NaturezaDespesaController::class, 'favoritar'])->name('natureza_despesa.fav');
Route::resource('natureza_despesa', NaturezaDespesaController::class);
Route::resource('subnatureza_despesa', SubnaturezaDespesaController::class);
Route::resource('centro_custo', CentroCustoController::class);

Route::resource('plano_estrategico', PlanoEstrategicoController::class);
Route::resource('plano_acao', PlanoAcaoController::class);
Route::resource('eixo_estrategico', EixoEstrategicoController::class);
Route::resource('dimensao', DimensaoController::class);
Route::resource('objetivo', ObjetivoController::class);
Route::post('meta/checkin/{meta_id}', [MetaController::class, 'checkin'])->name('meta.checkin');
Route::delete('meta/checkin/destroy/{meta_id}/{checkin_id}', [MetaController::class, 'destroy_checkin']);
Route::resource('meta', MetaController::class);
Route::get('agenda/eventos/{agenda_id}', [AgendaController::class, 'eventos'])->name('agenda.eventos');
Route::resource('agenda', AgendaController::class);
Route::resource('evento', EventoController::class);

Route::get('ploa/distribuicao/{unidade_gestora_id?}/{exercicio_id?}', [PloaController::class, 'distribuicao'])->name('ploa.distribuicao');
Route::get('ploa/{exercicio_id?}', [PloaController::class, 'index'])->name('ploa.index');
Route::resource('ploa', PloaController::class)->except([
    'index'
]);

Route::get('ploa_gestora/distribuicao/{unidade_administrativa_id?}/{exercicio_id?}', [PloaGestoraController::class, 'distribuicao'])->name('ploa_gestora.distribuicao');
Route::get('ploa_gestora/{unidade_gestora_id?}/{exercicio_id?}', [PloaGestoraController::class, 'index'])->name('ploa_gestora.index');
Route::resource('ploa_gestora', PloaGestoraController::class)->except([
    'index'
]);

Route::get('ploa_administrativa/{unidade_administrativa_id?}/{exercicio_id?}', [PloaAdministrativaController::class, 'index'])->name('ploa_administrativa.index');
Route::resource('ploa_administrativa', PloaAdministrativaController::class)->except([
    'index'
]);

Route::resource('despesa_modelo', DespesaModeloController::class);
Route::resource('despesa', DespesaController::class);

Route::get('relatorio', [RelatorioController::class, 'index'])->name('relatorio.index');
Route::get('relatorio/matriz/{instituicao_id?}/{exercicio_id?}', [RelatorioController::class, 'relatorio_matriz'])->name('relatorio.ploa');
Route::get('relatorio/planejamento/{unidade_administrativa_id?}/{exercicio_id?}', [RelatorioController::class, 'relatorio_planejamento'])->name('relatorio.ploa.planejamento');

Route::get('loa/loas/{ploa_id}', [LoaController::class, 'loas'])->name('loa.loas');
Route::get('loa/lista', [LoaController::class, 'lista'])->name('loa.lista');
Route::resource('loa', LoaController::class);
Route::get('loa_administrativa/lista', [LoaAdministrativaController::class, 'lista'])->name('loa-administrativa.lista');
Route::resource('loa_administrativa', LoaAdministrativaController::class);

Route::get('loa_gestora/lista', [LoaGestoraController::class, 'lista'])->name('loa-gestora.lista');
Route::resource('loa_gestora', LoaGestoraController::class);

Route::resource('credito_planejado', CreditoPlanejadoController::class);







