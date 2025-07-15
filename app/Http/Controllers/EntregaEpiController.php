<?php

namespace App\Http\Controllers;

use App\Models\EntregaEpi;
use App\Models\Colaborador;
use App\Models\Epi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importe o facade DB para transações

class EntregaEpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entregas = EntregaEpi::with(['colaborador', 'epi'])->paginate(10);
        return view('entregas.index', compact('entregas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colaboradores = Colaborador::orderBy('nome')->get();
        $epis = Epi::orderBy('nome')->get();
        return view('entregas.create', compact('colaboradores', 'epis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'colaborador_id' => 'required|exists:colaboradores,id',
            'epi_id' => 'required|exists:epis,id',
            'quantidade_entregue' => 'required|integer|min:1', // Alterado para quantidade_entregue
            'data_entrega' => 'required|date',
            'motivo' => 'nullable|string|max:255', // Alterado para motivo
        ]);

        // Inicia uma transação de banco de dados
        DB::beginTransaction();

        try {
            $epi = Epi::find($validatedData['epi_id']);

            // Verifica se há estoque suficiente antes de registrar a entrega
            if ($epi->quantidade_estoque < $validatedData['quantidade_entregue']) {
                DB::rollBack(); // Desfaz a transação
                return redirect()->back()->withInput()->with('error', 'Estoque insuficiente para o EPI selecionado.');
            }

            // Diminui a quantidade em estoque do EPI
            $epi->quantidade_estoque -= $validatedData['quantidade_entregue'];
            $epi->save();

            // Cria o registro de entrega
            EntregaEpi::create($validatedData);

            DB::commit(); // Confirma a transação
            return redirect()->route('entregas.index')->with('success', 'Entrega de EPI registrada com sucesso e estoque atualizado!');

        } catch (\Exception $e) {
            DB::rollBack(); // Desfaz a transação em caso de erro
            // Log do erro para depuração
            \Log::error('Erro ao registrar entrega de EPI: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao registrar a entrega de EPI. Tente novamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EntregaEpi $entrega) // Renomeado de $entregaEpi para $entrega para consistência
    {
        $entrega->load('colaborador', 'epi');
        return view('entregas.show', compact('entrega'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EntregaEpi $entrega) // Renomeado de $entregaEpi para $entrega para consistência
    {
        $colaboradores = Colaborador::orderBy('nome')->get();
        $epis = Epi::orderBy('nome')->get();
        return view('entregas.edit', compact('entrega', 'colaboradores', 'epis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EntregaEpi $entrega) // Renomeado de $entregaEpi para $entrega para consistência
    {
        $validatedData = $request->validate([
            'colaborador_id' => 'required|exists:colaboradores,id',
            'epi_id' => 'required|exists:epis,id',
            'quantidade_entregue' => 'required|integer|min:1',
            'data_entrega' => 'required|date',
            'motivo' => 'nullable|string|max:255',
        ]);

        // Inicia uma transação de banco de dados
        DB::beginTransaction();

        try {
            // Recupere a quantidade original da entrega antes de atualizar
            $quantidadeOriginal = $entrega->quantidade_entregue;
            $epiOriginalId = $entrega->epi_id;

            // Atualiza o registro de entrega
            $entrega->update($validatedData);

            // Se o EPI ou a quantidade mudou, ajuste o estoque
            if ($epiOriginalId != $entrega->epi_id || $quantidadeOriginal != $entrega->quantidade_entregue) {
                // Se o EPI mudou, precisamos devolver o estoque ao EPI antigo
                if ($epiOriginalId != $entrega->epi_id) {
                    $epiAntigo = Epi::find($epiOriginalId);
                    if ($epiAntigo) {
                        $epiAntigo->quantidade_estoque += $quantidadeOriginal;
                        $epiAntigo->save();
                    }
                } else {
                    // Se o EPI é o mesmo, ajuste a quantidade
                    $epi = Epi::find($entrega->epi_id);
                    $diferenca = $validatedData['quantidade_entregue'] - $quantidadeOriginal;

                    if ($diferenca > 0 && $epi->quantidade_estoque < $diferenca) {
                        DB::rollBack();
                        return redirect()->back()->withInput()->with('error', 'Estoque insuficiente para aumentar a quantidade entregue.');
                    }
                    $epi->quantidade_estoque -= $diferenca;
                    $epi->save();
                }
            }

            DB::commit();
            return redirect()->route('entregas.index')->with('success', 'Entrega de EPI atualizada com sucesso e estoque ajustado!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao atualizar entrega de EPI: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao atualizar a entrega de EPI. Tente novamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntregaEpi $entrega) // Renomeado de $entregaEpi para $entrega para consistência
    {
        // Inicia uma transação de banco de dados
        DB::beginTransaction();

        try {
            $epi = Epi::find($entrega->epi_id);

            // Devolve a quantidade entregue ao estoque do EPI
            if ($epi) {
                $epi->quantidade_estoque += $entrega->quantidade_entregue;
                $epi->save();
            }

            // Exclui o registro de entrega
            $entrega->delete();

            DB::commit();
            return redirect()->route('entregas.index')->with('success', 'Entrega de EPI excluída com sucesso e estoque restituído!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao excluir entrega de EPI: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir a entrega de EPI. Tente novamente.');
        }
    }
}