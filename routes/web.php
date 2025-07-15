<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CargoController; 
use App\Http\Controllers\DepartamentoController; 
use App\Http\Controllers\ColaboradorController; 
use App\Http\Controllers\EpiController; 
use App\Http\Controllers\EntregaEpiController; 
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\DashboardController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']) // Altere esta linha!
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas para Cargos (CRUD completo)
    Route::resource('cargos', CargoController::class);

    // Rotas para Departamentos (CRUD completo)
    Route::resource('departamentos', DepartamentoController::class);

    // Rotas para Colaboradores (CRUD completo)
    Route::resource('colaboradores', ColaboradorController::class)->parameters([
        'colaboradores' => 'colaborador',
    ]);
    // Rotas para EPIs (CRUD completo)
    Route::resource('epis', EpiController::class);

    // Rotas para Entrega de EPIs (CRUD completo)
    Route::resource('entregas', EntregaEpiController::class)->parameters(['entregas' => 'entregaEpi']);

    // Rotas de Relatórios
    Route::get('/relatorios/entregas-por-colaborador', [RelatorioController::class, 'entregasPorColaborador'])->name('relatorios.entregas_por_colaborador');
    Route::get('/relatorios/epis-mais-entregues', [RelatorioController::class, 'epiMaisEntregues'])->name('relatorios.epis_mais_entregues');
    // Adicione mais rotas de relatório conforme necessário
});

require __DIR__.'/auth.php';