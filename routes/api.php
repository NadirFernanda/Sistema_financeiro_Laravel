<?php
use App\Http\Controllers\AprovacaoController;
use App\Http\Controllers\ContratacaoController;
use App\Http\Controllers\MovimentoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\AuthController;

// Rota de aprovação (presidência)
Route::post('aprovacoes', [AprovacaoController::class, 'aprovar']);
// Rota de contratação
Route::patch('contratacao/{id}/verificar', [ContratacaoController::class, 'verificar']);
// Rotas de movimentos
Route::get('movimentos/faturas-disponiveis', [MovimentoController::class, 'faturasDisponiveis']);
Route::get('movimentos', [MovimentoController::class, 'index']);
// Rotas de relatórios
Route::get('relatorios/facturas-despesas', [RelatorioController::class, 'facturasDespesas']);
Route::get('relatorios/facturas-por-data', [RelatorioController::class, 'facturasPorData']);
Route::get('relatorios/facturas-dividas', [RelatorioController::class, 'facturasDividas']);
Route::get('relatorios/facturas-por-status', [RelatorioController::class, 'facturasPorStatus']);
Route::get('relatorios/despesas-por-ordem', [RelatorioController::class, 'despesasPorOrdem']);
Route::get('relatorios/exportar-faturas-excel', [RelatorioController::class, 'exportarFaturasExcel']);
// Rotas customizadas para status de faturas
Route::post('facturas/{id}/aprovar', [FacturaController::class, 'aprovar']);
Route::post('facturas/{id}/rejeitar', [FacturaController::class, 'rejeitar']);
Route::post('facturas/{id}/revisar', [FacturaController::class, 'revisar']);
// Rotas de usuários e faturas (CRUD)
Route::apiResource('usuarios', UserController::class);
Route::apiResource('facturas', FacturaController::class);
// Rota de login
Route::post('/login', [AuthController::class, 'login']);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
