<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do EPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <p class="text-lg font-semibold mb-2">Nome do EPI:</p>
                        <p class="text-gray-700 text-base">{{ $epi->nome }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-lg font-semibold mb-2">Descrição:</p>
                        <p class="text-gray-700 text-base">{{ $epi->descricao ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-lg font-semibold mb-2">CA (Certificado de Aprovação):</p>
                        <p class="text-gray-700 text-base">{{ $epi->ca }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-lg font-semibold mb-2">Validade do CA:</p>
                        <p class="text-gray-700 text-base">{{ $epi->validade_ca ? \Carbon\Carbon::parse($epi->validade_ca)->format('d/m/Y') : 'N/A' }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-lg font-semibold mb-2">Quantidade em Estoque:</p>
                        <p class="text-gray-700 text-base">{{ $epi->quantidade_estoque }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-lg font-semibold mb-2">Criado em:</p>
                        <p class="text-gray-700 text-base">{{ $epi->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold mb-2">Última Atualização:</p>
                        <p class="text-gray-700 text-base">{{ $epi->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <a href="{{ route('epis.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                            {{ __('Voltar para a Lista') }}
                        </a>
                        <a href="{{ route('epis.edit', $epi->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Editar EPI') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>