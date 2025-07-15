<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargos = Cargo::paginate(10); // Paginação de 10 por página
        return view('cargos.index', compact('cargos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cargos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:cargos,nome',
        ]);

        Cargo::create($request->all());

        return redirect()->route('cargos.index')->with('success', 'Cargo cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cargo $cargo)
    {
        return view('cargos.show', compact('cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cargo $cargo)
    {
        return view('cargos.edit', compact('cargo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cargo $cargo)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:cargos,nome,' . $cargo->id,
        ]);

        $cargo->update($request->all());

        return redirect()->route('cargos.index')->with('success', 'Cargo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        // Verificar se há colaboradores associados antes de deletar
        if ($cargo->colaboradores()->count() > 0) {
            return redirect()->route('cargos.index')->with('error', 'Não é possível excluir o cargo, pois existem colaboradores associados a ele.');
        }

        $cargo->delete();

        return redirect()->route('cargos.index')->with('success', 'Cargo excluído com sucesso!');
    }
}