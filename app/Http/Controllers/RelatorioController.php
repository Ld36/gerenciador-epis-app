<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\EntregaEpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function entregasPorColaborador()
    {
        $dadosRelatorio = DB::table('entrega_epis')
            ->select(DB::raw('colaboradores.nome as colaborador_nome, COUNT(entrega_epis.id) as total_entregas'))
            ->join('colaboradores', 'entrega_epis.colaborador_id', '=', 'colaboradores.id')
            ->groupBy('colaboradores.nome')
            ->orderBy('total_entregas', 'desc')
            ->get();

        $labels = $dadosRelatorio->pluck('colaborador_nome')->toArray();
        $data = $dadosRelatorio->pluck('total_entregas')->toArray();

        return view('relatorios.entregas_por_colaborador', compact('labels', 'data'));
    }

    public function epiMaisEntregues()
    {
        $dadosRelatorio = DB::table('entrega_epis')
            ->select(DB::raw('epis.nome as epi_nome, COUNT(entrega_epis.id) as total_entregas'))
            ->join('epis', 'entrega_epis.epi_id', '=', 'epis.id')
            ->groupBy('epis.nome')
            ->orderBy('total_entregas', 'desc')
            ->get();

        $labels = $dadosRelatorio->pluck('epi_nome')->toArray();
        $data = $dadosRelatorio->pluck('total_entregas')->toArray();

        return view('relatorios.epis_mais_entregues', compact('labels', 'data'));
    }
}