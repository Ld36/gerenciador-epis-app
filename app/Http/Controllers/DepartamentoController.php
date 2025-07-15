<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos = Departamento::paginate(10);
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:departamentos,nome',
        ]);

        Departamento::create($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamento $departamento)
    {
        return view('departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', compact('departamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:departamentos,nome,' . $departamento->id,
        ]);

        $departamento->update($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        // Verificar se há colaboradores associados antes de deletar
        if ($departamento->colaboradores()->count() > 0) {
            return redirect()->route('departamentos.index')->with('error', 'Não é possível excluir o departamento, pois existem colaboradores associados a ele.');
        }

        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento excluído com sucesso!');
    }
}