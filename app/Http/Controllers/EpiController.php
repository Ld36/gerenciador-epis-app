<?php

namespace App\Http\Controllers;

use App\Models\Epi;
use Illuminate\Http\Request;

class EpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $epis = Epi::paginate(10);
        return view('epis.index', compact('epis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('epis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ca' => 'required|string|max:50|unique:epis,ca',
            'validade_ca' => 'nullable|date',
            'quantidade_estoque' => 'required|integer|min:0',
        ]);

        Epi::create($request->all());

        return redirect()->route('epis.index')->with('success', 'EPI cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Epi $epi)
    {
        $epi->load('entregas.colaborador'); // Carregar entregas e os colaboradores associados
        return view('epis.show', compact('epi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Epi $epi)
    {
        return view('epis.edit', compact('epi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Epi $epi)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ca' => 'required|string|max:50|unique:epis,ca,' . $epi->id,
            'validade_ca' => 'nullable|date',
            'quantidade_estoque' => 'required|integer|min:0',
        ]);

        $epi->update($request->all());

        return redirect()->route('epis.index')->with('success', 'EPI atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Epi $epi)
    {
        // Verificar se há entregas de EPIs associadas antes de deletar
        if ($epi->entregas()->count() > 0) {
            return redirect()->route('epis.index')->with('error', 'Não é possível excluir o EPI, pois existem entregas associadas a ele.');
        }

        $epi->delete();

        return redirect()->route('epis.index')->with('success', 'EPI excluído com sucesso!');
    }
}