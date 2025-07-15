<?php

namespace App\Http\Controllers;

use App\Models\Epi;
use App\Models\Colaborador;
use App\Models\EntregaEpi;
use Carbon\Carbon; // Importe a classe Carbon

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Contagem total de Colaboradores e EPIs
        $totalColaboradores = Colaborador::count();
        $totalEpis = Epi::count();
        $totalEntregas = EntregaEpi::count();

        // 2. EPIs com Estoque Baixo (ex: abaixo de 20 unidades)
        $episBaixoEstoque = Epi::where('quantidade_estoque', '<', 20)->orderBy('quantidade_estoque')->get();

        // 3. EPIs com CA Próximo do Vencimento (ex: vencem nos próximos 90 dias)
        $dataLimiteCA = Carbon::now()->addDays(90);
        $episCaVencendo = Epi::where('validade_ca', '<', $dataLimiteCA)
                             ->orderBy('validade_ca', 'asc')
                             ->get();

        // 4. Entregas Recentes (ex: as últimas 5 entregas)
        $entregasRecentes = EntregaEpi::with(['colaborador', 'epi'])
                                      ->orderBy('created_at', 'desc')
                                      ->take(5)
                                      ->get();


        return view('dashboard', compact(
            'totalColaboradores',
            'totalEpis',
            'totalEntregas',
            'episBaixoEstoque',
            'episCaVencendo',
            'entregasRecentes'
        ));
    }
}