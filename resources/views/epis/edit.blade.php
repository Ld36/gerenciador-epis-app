<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar EPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('epis.update', $epi->id) }}">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <x-input-label for="nome" :value="__('Nome do EPI')" />
                            <x-text-input id="nome" class="block mt-1 w-full" type="text" name="nome" :value="old('nome', $epi->nome)" required autofocus />
                            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="descricao" :value="__('Descrição')" />
                            <textarea id="descricao" name="descricao" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('descricao', $epi->descricao) }}</textarea>
                            <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="ca" :value="__('CA (Certificado de Aprovação)')" />
                            <x-text-input id="ca" class="block mt-1 w-full" type="text" name="ca" :value="old('ca', $epi->ca)" required />
                            <x-input-error :messages="$errors->get('ca')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="validade_ca" :value="__('Validade do CA')" />
                            <x-text-input id="validade_ca" class="block mt-1 w-full" type="date" name="validade_ca" :value="old('validade_ca', $epi->validade_ca)" />
                            <x-input-error :messages="$errors->get('validade_ca')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="quantidade_estoque" :value="__('Quantidade em Estoque')" />
                            <x-text-input id="quantidade_estoque" class="block mt-1 w-full" type="number" name="quantidade_estoque" :value="old('quantidade_estoque', $epi->quantidade_estoque)" required min="0" />
                            <x-input-error :messages="$errors->get('quantidade_estoque')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('epis.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Salvar Alterações') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>