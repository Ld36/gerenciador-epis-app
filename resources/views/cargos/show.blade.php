<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Cargo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <p class="text-lg font-semibold mb-2">Nome do Cargo:</p>
                        <p class="text-gray-700 text-base">{{ $cargo->nome }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-lg font-semibold mb-2">Criado em:</p>
                        <p class="text-gray-700 text-base">{{ $cargo->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold mb-2">Última Atualização:</p>
                        <p class="text-gray-700 text-base">{{ $cargo->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <a href="{{ route('cargos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                            {{ __('Voltar para a Lista') }}
                        </a>
                        <a href="{{ route('cargos.edit', $cargo->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Editar Cargo') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>