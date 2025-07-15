<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Entrega de EPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('entregas.update', $entrega->id) }}">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <x-input-label for="colaborador_id" :value="__('Colaborador')" />
                            <select id="colaborador_id" name="colaborador_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Selecione um Colaborador</option>
                                @foreach ($colaboradores as $colaborador)
                                    <option value="{{ $colaborador->id }}" {{ old('colaborador_id', $entrega->colaborador_id) == $colaborador->id ? 'selected' : '' }}>
                                        {{ $colaborador->nome }} (CPF: {{ $colaborador->cpf }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('colaborador_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="epi_id" :value="__('EPI')" />
                            <select id="epi_id" name="epi_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Selecione um EPI</option>
                                @foreach ($epis as $epi)
                                    <option value="{{ $epi->id }}" {{ old('epi_id', $entrega->epi_id) == $epi->id ? 'selected' : '' }}>
                                        {{ $epi->nome }} (CA: {{ $epi->ca }}) - Estoque: {{ $epi->quantidade_estoque }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('epi_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="quantidade_entregue" :value="__('Quantidade Entregue')" />
                            <x-text-input id="quantidade_entregue" class="block mt-1 w-full" type="number" name="quantidade_entregue" :value="old('quantidade_entregue', $entrega->quantidade_entregue)" required min="1" />
                            <x-input-error :messages="$errors->get('quantidade_entregue')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="data_entrega" :value="__('Data da Entrega')" />
                            <x-text-input id="data_entrega" class="block mt-1 w-full" type="date" name="data_entrega" :value="old('data_entrega', \Carbon\Carbon::parse($entrega->data_entrega)->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('data_entrega')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="motivo" :value="__('Motivo da Entrega')" />
                            <textarea id="motivo" name="motivo" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('motivo', $entrega->motivo) }}</textarea>
                            <x-input-error :messages="$errors->get('motivo')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('entregas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
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