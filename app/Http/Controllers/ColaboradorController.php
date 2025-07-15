<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\Cargo;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colaboradores = Colaborador::with(['cargo', 'departamento'])->paginate(10);
        return view('colaboradores.index', compact('colaboradores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cargos = Cargo::all();
        $departamentos = Departamento::all();
        return view('colaboradores.create', compact('cargos', 'departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:colaboradores,cpf',
            'matricula' => 'required|string|max:50|unique:colaboradores,matricula',
            'data_nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'cargo_id' => 'required|exists:cargos,id',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        Colaborador::create($request->all());

        return redirect()->route('colaboradores.index')->with('success', 'Colaborador cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colaborador $colaborador)
    {
        // Carregar os relacionamentos para exibir detalhes
        $colaborador->load('cargo', 'departamento', 'entregas.epi');
        return view('colaboradores.show', compact('colaborador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colaborador $colaborador)
    {
        $cargos = Cargo::all();
        $departamentos = Departamento::all();
        return view('colaboradores.edit', compact('colaborador', 'cargos', 'departamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colaborador $colaborador)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => [
                'required',
                'string',
                'max:14',
                Rule::unique('colaboradores')->ignore($colaborador->id), // Ignora o próprio CPF do colaborador atual
            ],
            'matricula' => [
                'required',
                'string',
                'max:20',
                Rule::unique('colaboradores')->ignore($colaborador->id), // Ignora a própria matrícula do colaborador atual
            ],
            'data_nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:20',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('colaboradores')->ignore($colaborador->id), // Ignora o próprio email do colaborador atual
            ],
            'cargo_id' => 'required|exists:cargos,id',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        $colaborador->update($request->all());

        return redirect()->route('colaboradores.index')->with('success', 'Colaborador atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colaborador $colaborador)
    {
        // Verificar se há entregas de EPIs associadas antes de deletar
        if ($colaborador->entregas()->count() > 0) {
            return redirect()->route('colaboradores.index')->with('error', 'Não é possível excluir o colaborador, pois existem entregas de EPIs associadas a ele.');
        }

        $colaborador->delete();

        return redirect()->route('colaboradores.index')->with('success', 'Colaborador excluído com sucesso!');
    }
}