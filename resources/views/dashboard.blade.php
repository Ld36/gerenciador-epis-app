<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard do Gerenciador de EPIs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-md">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3H5a3 3 0 00-3 3v2h5M17 20v-2a3 3 0 00-3-3H5a3 3 0 00-3 3v2m3-3h6m-6 0h6m-6 0h6"></path>
                                </svg>
                                <div>
                                    <p class="font-bold text-lg">Colaboradores Cadastrados</p>
                                    <p class="text-3xl">{{ $totalColaboradores }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 002 12c0 2.977 1.287 5.676 3.355 7.5l-1.041 1.041a1 1 0 001.414 1.414L5.355 21a12.001 12.001 0 0014.29-9c0-2.977-1.287-5.676-3.355-7.5z"></path>
                                </svg>
                                <div>
                                    <p class="font-bold text-lg">EPIs Cadastrados</p>
                                    <p class="text-3xl">{{ $totalEpis }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-100 border-l-4 border-purple-500 text-purple-700 p-4 rounded-lg shadow-md">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-purple-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <div>
                                    <p class="font-bold text-lg">Entregas Realizadas</p>
                                    <p class="text-3xl">{{ $totalEntregas }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md">
                            <div class="flex items-center mb-3">
                                <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <h3 class="font-bold text-lg">Atenção: EPIs com Estoque Baixo!</h3>
                            </div>
                            @if ($episBaixoEstoque->isEmpty())
                                <p>Nenhum EPI com estoque abaixo do limite. Ótimo!</p>
                            @else
                                <ul class="list-disc list-inside">
                                    @foreach ($episBaixoEstoque as $epi)
                                        <li>{{ $epi->nome }} (CA: {{ $epi->ca }}) - **Estoque: {{ $epi->quantidade_estoque }}**</li>
                                    @endforeach
                                </ul>
                                <p class="mt-2 text-sm">Considere reabastecer estes itens.</p>
                            @endif
                        </div>

                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-md">
                            <div class="flex items-center mb-3">
                                <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="font-bold text-lg">Atenção: CAs Próximos do Vencimento!</h3>
                            </div>
                            @if ($episCaVencendo->isEmpty())
                                <p>Nenhum CA de EPI próximo do vencimento nos próximos 90 dias. Ótimo!</p>
                            @else
                                <ul class="list-disc list-inside">
                                    @foreach ($episCaVencendo as $epi)
                                        <li>{{ $epi->nome }} (CA: {{ $epi->ca }}) - **Válido até: {{ \Carbon\Carbon::parse($epi->validade_ca)->format('d/m/Y') }}**</li>
                                    @endforeach
                                </ul>
                                <p class="mt-2 text-sm">Verifique a validade e providencie a renovação ou substituição.</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 border-l-4 border-gray-400 text-gray-800 p-4 rounded-lg shadow-md">
                        <div class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                            <h3 class="font-bold text-lg">Últimas Entregas Realizadas</h3>
                        </div>
                        @if ($entregasRecentes->isEmpty())
                            <p>Nenhuma entrega recente registrada.</p>
                        @else
                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="py-3 px-6">Data</th>
                                            <th scope="col" class="py-3 px-6">Colaborador</th>
                                            <th scope="col" class="py-3 px-6">EPI</th>
                                            <th scope="col" class="py-3 px-6">Qtd.</th>
                                            <th scope="col" class="py-3 px-6">Motivo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entregasRecentes as $entrega)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <td class="py-2 px-6">{{ \Carbon\Carbon::parse($entrega->data_entrega)->format('d/m/Y') }}</td>
                                                <td class="py-2 px-6">{{ $entrega->colaborador->nome ?? 'N/A' }}</td>
                                                <td class="py-2 px-6">{{ $entrega->epi->nome ?? 'N/A' }}</td>
                                                <td class="py-2 px-6">{{ $entrega->quantidade_entregue }}</td>
                                                <td class="py-2 px-6">{{ $entrega->motivo }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('entregas.index') }}" class="text-blue-600 hover:underline text-sm">Ver todas as entregas &rarr;</a>
                            </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>